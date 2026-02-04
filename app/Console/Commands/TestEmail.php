<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'email:test';
    protected $description = 'Test email configuration';

    public function handle()
    {
        $this->info('=== Email Configuration Test ===');
        $this->newLine();

        $this->info('Checking configuration...');
        $this->line('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
        $this->line('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
        $this->line('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
        $this->line('MAIL_FROM: ' . config('mail.from.address'));
        $this->newLine();

        if (config('mail.mailers.smtp.username') === 'your-gmail@gmail.com') {
            $this->error('⚠️  WARNING: Gmail credentials not updated!');
            return 1;
        }

        $this->info('Sending test email...');
        $this->line('To: ' . config('mail.mailers.smtp.username'));
        $this->newLine();

        try {
            Mail::raw('🎉 Success! Your Password Manager email configuration is working correctly.', function($message) {
                $message->to(config('mail.mailers.smtp.username'))
                        ->subject('✅ Password Manager - Email Test Successful');
            });
            
            $this->newLine();
            $this->info('✅ Test email sent successfully!');
            $this->line('Check your inbox: ' . config('mail.mailers.smtp.username'));
            $this->newLine();
            $this->info('🎊 Your email configuration is working!');
            $this->newLine();
            
            return 0;
            
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('❌ Error sending email:');
            $this->error($e->getMessage());
            $this->newLine();
            
            $this->warn('💡 Troubleshooting tips:');
            $this->line('1. Check your Gmail App Password is correct');
            $this->line('2. Make sure 2-Step Verification is enabled on Gmail');
            $this->line('3. Remove spaces from the app password');
            $this->line('4. Run: php artisan config:clear');
            $this->line('5. Check storage/logs/laravel.log for details');
            $this->newLine();
            
            return 1;
        }
    }
}
