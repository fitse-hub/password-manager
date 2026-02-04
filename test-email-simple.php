<?php

use Illuminate\Support\Facades\Mail;

echo "\n=== Email Configuration Test ===\n\n";

echo "Checking configuration...\n";
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "MAIL_FROM: " . config('mail.from.address') . "\n\n";

if (config('mail.mailers.smtp.username') === 'your-gmail@gmail.com') {
    echo "⚠️  WARNING: Gmail credentials not updated!\n\n";
    exit;
}

echo "Sending test email...\n";

try {
    Mail::raw('Success! Your Password Manager email is working.', function($message) {
        $message->to(config('mail.mailers.smtp.username'))
                ->subject('Password Manager - Email Test');
    });
    
    echo "\n✅ Test email sent successfully!\n";
    echo "Check inbox: " . config('mail.mailers.smtp.username') . "\n\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n\n";
}

echo "=== Test Complete ===\n\n";
