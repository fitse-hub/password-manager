<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogService;
use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function __construct(
        private EncryptionService $encryption,
        private ActivityLogService $activityLog
    ) {
    }

    public function showForm()
    {
        return view('export');
    }

    public function export(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
            'format' => 'required|in:json,csv',
            'export_password' => 'nullable|string|min:12',
        ]);

        $user = Auth::user();
        $credentials = $user->credentials()->with('category')->get();

        $data = [];

        foreach ($credentials as $credential) {
            try {
                $password = $this->encryption->decrypt(
                    $credential->encrypted_password,
                    $credential->encryption_iv
                );

                $notes = $credential->encrypted_notes 
                    ? $this->encryption->decrypt($credential->encrypted_notes, $credential->encryption_iv)
                    : '';

                $data[] = [
                    'website_name' => $credential->website_name,
                    'website_url' => $credential->website_url,
                    'username_email' => $credential->username_email,
                    'password' => $password,
                    'category' => $credential->category?->name ?? '',
                    'notes' => $notes,
                    'is_favorite' => $credential->is_favorite,
                    'created_at' => $credential->created_at->toDateTimeString(),
                ];
            } catch (\Exception $e) {
                // If decryption fails, include error message instead
                \Log::error('Export decryption failed for credential ' . $credential->id . ': ' . $e->getMessage());
                
                $data[] = [
                    'website_name' => $credential->website_name,
                    'website_url' => $credential->website_url,
                    'username_email' => $credential->username_email,
                    'password' => '[DECRYPTION FAILED]',
                    'category' => $credential->category?->name ?? '',
                    'notes' => '[DECRYPTION FAILED]',
                    'is_favorite' => $credential->is_favorite,
                    'created_at' => $credential->created_at->toDateTimeString(),
                ];
            }
        }

        $this->activityLog->log('data_exported', null, null);

        if ($request->format === 'json') {
            $content = json_encode([
                'exported_at' => now()->toDateTimeString(),
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'credentials' => $data,
            ], JSON_PRETTY_PRINT);

            // Encrypt if export password provided
            if ($request->export_password) {
                $encrypted = $this->encryptExport($content, $request->export_password);
                $filename = 'password-manager-export-' . now()->format('Y-m-d-His') . '.encrypted.json';
                
                return response($encrypted)
                    ->header('Content-Type', 'application/json')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->header('X-Content-Type-Options', 'nosniff');
            }

            $filename = 'password-manager-export-' . now()->format('Y-m-d-His') . '.json';
            
            return response($content)
                ->header('Content-Type', 'application/json')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }

        // CSV Export
        $csv = "Website,URL,Username/Email,Password,Category,Notes,Favorite,Created At\n";
        
        foreach ($data as $row) {
            $csv .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                str_replace('"', '""', $row['website_name']),
                str_replace('"', '""', $row['website_url'] ?? ''),
                str_replace('"', '""', $row['username_email']),
                str_replace('"', '""', $row['password']),
                str_replace('"', '""', $row['category']),
                str_replace('"', '""', $row['notes']),
                $row['is_favorite'] ? 'Yes' : 'No',
                $row['created_at']
            );
        }

        // Encrypt if export password provided
        if ($request->export_password) {
            $encrypted = $this->encryptExport($csv, $request->export_password);
            $filename = 'password-manager-export-' . now()->format('Y-m-d-His') . '.encrypted.csv';
            
            return response($encrypted)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('X-Content-Type-Options', 'nosniff');
        }

        $filename = 'password-manager-export-' . now()->format('Y-m-d-His') . '.csv';
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function encryptExport(string $data, string $password): string
    {
        $iv = random_bytes(16);
        $key = hash('sha256', $password, true);
        
        $encrypted = openssl_encrypt(
            $data,
            'AES-256-CBC',
            $key,
            0,
            $iv
        );

        return base64_encode($iv . $encrypted);
    }
}
