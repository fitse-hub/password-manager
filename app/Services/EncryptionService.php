<?php

namespace App\Services;

class EncryptionService
{
    public function encrypt(string $data): array
    {
        $key = base64_decode(substr(config('app.key'), 7)); // Remove 'base64:' prefix
        $iv = random_bytes(16);
        $tag = '';
        
        $encrypted = openssl_encrypt(
            $data,
            'AES-256-GCM',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return [
            'encrypted' => base64_encode($encrypted . $tag),
            'iv' => base64_encode($iv),
        ];
    }

    public function decrypt(string $encrypted, string $iv): string
    {
        $key = base64_decode(substr(config('app.key'), 7)); // Remove 'base64:' prefix
        $decoded = base64_decode($encrypted);
        
        // Extract tag (last 16 bytes)
        $ciphertext = substr($decoded, 0, -16);
        $tag = substr($decoded, -16);

        $decrypted = openssl_decrypt(
            $ciphertext,
            'AES-256-GCM',
            $key,
            OPENSSL_RAW_DATA,
            base64_decode($iv),
            $tag
        );

        if ($decrypted === false) {
            throw new \Exception('Decryption failed');
        }

        return $decrypted;
    }
}
