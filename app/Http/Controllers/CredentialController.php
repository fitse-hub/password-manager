<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use App\Services\ActivityLogService;
use App\Services\EncryptionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CredentialController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private EncryptionService $encryption,
        private ActivityLogService $activityLog
    ) {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'website_name' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'username_email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $encryptedPassword = $this->encryption->encrypt($validated['password']);
        $encryptedNotes = !empty($validated['notes']) 
            ? $this->encryption->encrypt($validated['notes'])['encrypted']
            : null;

        $credential = Auth::user()->credentials()->create([
            'website_name' => $validated['website_name'],
            'website_url' => $validated['website_url'],
            'username_email' => $validated['username_email'],
            'encrypted_password' => $encryptedPassword['encrypted'],
            'encrypted_notes' => $encryptedNotes,
            'encryption_iv' => $encryptedPassword['iv'],
            'category_id' => $validated['category_id'],
            'password_updated_at' => now(),
        ]);

        $this->activityLog->log('credential_created', 'Credential', $credential->id);

        return redirect()->route('dashboard')->with('success', 'Credential added successfully!');
    }

    public function update(Request $request, Credential $credential)
    {
        $this->authorize('update', $credential);

        $validated = $request->validate([
            'website_name' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'username_email' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $updateData = [
            'website_name' => $validated['website_name'],
            'website_url' => $validated['website_url'],
            'username_email' => $validated['username_email'],
            'category_id' => $validated['category_id'],
        ];

        if (!empty($validated['password'])) {
            $encryptedPassword = $this->encryption->encrypt($validated['password']);
            $updateData['encrypted_password'] = $encryptedPassword['encrypted'];
            $updateData['encryption_iv'] = $encryptedPassword['iv'];
            $updateData['password_updated_at'] = now();
        }

        if (isset($validated['notes'])) {
            $updateData['encrypted_notes'] = !empty($validated['notes'])
                ? $this->encryption->encrypt($validated['notes'])['encrypted']
                : null;
        }

        $credential->update($updateData);

        $this->activityLog->log('credential_updated', 'Credential', $credential->id);

        return redirect()->route('dashboard')->with('success', 'Credential updated successfully!');
    }

    public function destroy(Credential $credential)
    {
        $this->authorize('delete', $credential);

        $this->activityLog->log('credential_deleted', 'Credential', $credential->id);

        $credential->delete();

        return redirect()->route('dashboard')->with('success', 'Credential deleted successfully!');
    }

    public function decrypt(Credential $credential)
    {
        $this->authorize('view', $credential);

        try {
            $decryptedPassword = $this->encryption->decrypt(
                $credential->encrypted_password,
                $credential->encryption_iv
            );

            $this->activityLog->log('credential_viewed', 'Credential', $credential->id);

            return response()->json(['password' => $decryptedPassword]);
        } catch (\Exception $e) {
            \Log::error('Decryption failed: ' . $e->getMessage(), [
                'credential_id' => $credential->id,
                'encrypted_password_length' => strlen($credential->encrypted_password),
                'iv_length' => strlen($credential->encryption_iv),
            ]);
            
            return response()->json([
                'error' => 'Failed to decrypt password',
                'message' => 'The password could not be decrypted. This may be due to a corrupted encryption key or data.'
            ], 500);
        }
    }

    public function toggleFavorite(Credential $credential)
    {
        $this->authorize('update', $credential);

        $credential->update([
            'is_favorite' => !$credential->is_favorite,
        ]);

        $action = $credential->is_favorite ? 'added to' : 'removed from';
        $this->activityLog->log('credential_favorite_toggled', 'Credential', $credential->id);

        return response()->json([
            'success' => true,
            'is_favorite' => $credential->is_favorite,
            'message' => "Credential {$action} favorites"
        ]);
    }
}
