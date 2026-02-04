<?php

/**
 * Email Configuration Test Script
 * 
 * This script helps you test your Gmail SMTP configuration
 * Run this after updating your .env file with Gmail credentials
 * 
 * Usage: php artisan tinker < test-email.php
 */

use Illuminate\Support\Facades\Mail;

echo "\n=== Password Manager Email Test ===\n\n";

// Test 1: Check configuration
echo "1. Checking email configuration...\n";
echo "   MAIL_MAILER: " . config('mail.default') . "\n";
echo "   MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "   MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "   MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "   MAIL_FROM: " . config('mail.from.address') . "\n\n";

// Test 2: Check if credentials are set
if (config('mail.mailers.smtp.username') === 'your-gmail@gmail.com') {
    echo "⚠️  WARNING: You haven't updated your Gmail credentials yet!\n";
    echo "   Please update MAIL_USERNAME in your .env file\n\n";
    exit;
}

if (config('mail.mailers.smtp.password') === 'your-16-char-app-password') {
    echo "⚠️  WARNING: You haven't updated your Gmail App Password yet!\n";
    echo "   Please update MAIL_PASSWORD in your .env file\n\n";
    exit;
}

echo "✅ Configuration looks good!\n\n";

// Test 3: Send test email
echo "2. Sending test email...\n";
echo "   To: " . config('mail.mailers.smtp.username') . "\n";

try {
    Mail::raw('🎉 Success! Your Password Manager email configuration is working correctly.', function($message) {
        $message->to(config('mail.mailers.smtp.username'))
                ->subject('✅ Password Manager - Email Test Successful');
    });
    
    echo "\n✅ Test email sent successfully!\n";
    echo "   Check your inbox: " . config('mail.mailers.smtp.username') . "\n";
    echo "   Subject: ✅ Password Manager - Email Test Successful\n\n";
    
    echo "🎊 Your email configuration is working!\n";
    echo "   You can now test:\n";
    echo "   - User registration email verification\n";
    echo "   - Password reset emails\n\n";
    
} catch (\Exception $e) {
    echo "\n❌ Error sending email:\n";
    echo "   " . $e->getMessage() . "\n\n";
    
    echo "💡 Troubleshooting tips:\n";
    echo "   1. Check your Gmail App Password is correct\n";
    echo "   2. Make sure 2-Step Verification is enabled on Gmail\n";
    echo "   3. Remove spaces from the app password\n";
    echo "   4. Run: php artisan config:clear\n";
    echo "   5. Check storage/logs/laravel.log for details\n\n";
}

echo "=== Test Complete ===\n\n";
