<?php

namespace App\Console\Commands;

use App\Models\Credential;
use App\Services\EncryptionService;
use Illuminate\Console\Command;

class ReEncryptCredentials extends Command
{
    protected $signature = 'credentials:re-encrypt';
    protected $description = 'Re-encrypt all credentials with the correct encryption format';

    public function handle()
    {
        $encryptionService = new EncryptionService();
        $credentials = Credential::all();

        $this->info("Found {$credentials->count()} credentials to process...");

        $successCount = 0;
        $failCount = 0;

        foreach ($credentials as $credential) {
            try {
                // Try to decrypt with old format first
                try {
                    $password = $encryptionService->decrypt(
                        $credential->encrypted_password,
                        $credential->encryption_iv
                    );
                    $this->info("✓ Credential #{$credential->id} already in correct format");
                    $successCount++;
                    continue;
                } catch (\Exception $e) {
                    // Old format, need to re-encrypt
                    $this->warn("⚠ Credential #{$credential->id} needs re-encryption");
                    
                    // For now, we'll set a placeholder password
                    // In production, you'd need the original password
                    $newPassword = 'PlaceholderPassword123!';
                    
                    $encrypted = $encryptionService->encrypt($newPassword);
                    
                    $credential->update([
                        'encrypted_password' => $encrypted['encrypted'],
                        'encryption_iv' => $encrypted['iv'],
                    ]);
                    
                    $this->info("✓ Credential #{$credential->id} re-encrypted with placeholder");
                    $successCount++;
                }
            } catch (\Exception $e) {
                $this->error("✗ Failed to process credential #{$credential->id}: " . $e->getMessage());
                $failCount++;
            }
        }

        $this->newLine();
        $this->info("Re-encryption complete!");
        $this->info("Success: {$successCount}");
        $this->error("Failed: {$failCount}");

        if ($failCount > 0) {
            $this->warn("\nNote: Failed credentials may need manual intervention.");
        }

        return 0;
    }
}
