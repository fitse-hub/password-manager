<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use App\Services\EncryptionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PasswordHealthController extends Controller
{
    public function __construct(private EncryptionService $encryption)
    {
    }

    public function index()
    {
        $user = Auth::user();
        $credentials = $user->credentials()->get();

        $weakPasswords = [];
        $reusedPasswords = [];
        $oldPasswords = [];
        $passwordHashes = [];

        foreach ($credentials as $credential) {
            try {
                $password = $this->encryption->decrypt(
                    $credential->encrypted_password,
                    $credential->encryption_iv
                );

                // Check password strength
                $strength = $this->calculateStrength($password);
                if ($strength === 'weak' || $strength === 'medium') {
                    $weakPasswords[] = [
                        'credential' => $credential,
                        'strength' => $strength,
                    ];
                }

                // Check for reused passwords
                $hash = hash('sha256', $password);
                if (isset($passwordHashes[$hash])) {
                    $reusedPasswords[] = [
                        'credential' => $credential,
                        'reused_with' => $passwordHashes[$hash],
                    ];
                } else {
                    $passwordHashes[$hash] = $credential;
                }

                // Check password age (older than 90 days)
                $passwordAge = $credential->password_updated_at 
                    ? Carbon::parse($credential->password_updated_at) 
                    : Carbon::parse($credential->created_at);
                
                $daysSinceUpdate = $passwordAge->diffInDays(Carbon::now());
                
                if ($daysSinceUpdate >= 90) {
                    $oldPasswords[] = [
                        'credential' => $credential,
                        'age_days' => $daysSinceUpdate,
                    ];
                }
            } catch (\Exception $e) {
                // Skip if decryption fails
                continue;
            }
        }

        $stats = [
            'total' => $credentials->count(),
            'weak' => count($weakPasswords),
            'reused' => count($reusedPasswords),
            'old' => count($oldPasswords),
            'strong' => $credentials->count() - count($weakPasswords),
            'score' => $this->calculateHealthScore($credentials->count(), count($weakPasswords), count($reusedPasswords), count($oldPasswords)),
        ];

        return view('password-health', compact('stats', 'weakPasswords', 'reusedPasswords', 'oldPasswords'));
    }

    private function calculateStrength(string $password): string
    {
        $score = 0;
        $length = strlen($password);

        if ($length >= 12) $score += 2;
        elseif ($length >= 8) $score += 1;

        if (preg_match('/[a-z]/', $password)) $score += 1;
        if (preg_match('/[A-Z]/', $password)) $score += 1;
        if (preg_match('/[0-9]/', $password)) $score += 1;
        if (preg_match('/[^a-zA-Z0-9]/', $password)) $score += 1;

        if ($score >= 6) return 'very_strong';
        if ($score >= 5) return 'strong';
        if ($score >= 3) return 'medium';
        return 'weak';
    }

    private function calculateHealthScore(int $total, int $weak, int $reused, int $old): int
    {
        if ($total === 0) return 100;

        $weakPenalty = ($weak / $total) * 40;
        $reusedPenalty = ($reused / $total) * 30;
        $oldPenalty = ($old / $total) * 30;

        $score = 100 - ($weakPenalty + $reusedPenalty + $oldPenalty);

        return max(0, min(100, (int) $score));
    }
}
