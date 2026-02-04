# Quick Email Setup (5 Minutes)

## Fastest Way: Use Mailtrap (Free, No Setup)

### Step 1: Get Mailtrap Credentials (2 minutes)
1. Go to https://mailtrap.io
2. Sign up (free, no credit card)
3. Click on your inbox
4. Copy the SMTP credentials

### Step 2: Update Your .env File (1 minute)
Open `.env` and update these lines:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=paste-your-username-here
MAIL_PASSWORD=paste-your-password-here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@passwordmanager.com
MAIL_FROM_NAME="Password Manager"
```

### Step 3: Clear Cache (30 seconds)
```bash
php artisan config:clear
php artisan cache:clear
```

### Step 4: Test It! (1 minute)
1. Register a new user account
2. Check Mailtrap inbox - email appears instantly!
3. Click the verification link
4. Done! ✅

## Alternative: Gmail (If you have Gmail)

### Step 1: Generate App Password
1. Go to https://myaccount.google.com/apppasswords
2. Create app password for "Mail"
3. Copy the 16-character password

### Step 2: Update .env
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youremail@gmail.com
MAIL_FROM_NAME="Password Manager"
```

### Step 3: Clear Cache & Test
```bash
php artisan config:clear
php artisan cache:clear
```

Then register a new user and check your Gmail!

## What's Already Working

Your app already has:
- ✅ Email verification system
- ✅ Password reset emails
- ✅ Email templates
- ✅ Secure signed links
- ✅ Token expiration

You just need to configure SMTP!

## Test Commands

### Send Test Email:
```bash
php artisan tinker
```

Then:
```php
Mail::raw('Test from Password Manager', function($msg) {
    $msg->to('test@example.com')->subject('Test');
});
```

### Check if email was queued:
```bash
php artisan queue:work
```

## Troubleshooting

**Emails not sending?**
- Run: `php artisan config:clear`
- Check: `storage/logs/laravel.log`
- Verify SMTP credentials

**Using Mailtrap but no emails?**
- Check you're logged into Mailtrap
- Refresh the inbox page
- Emails appear instantly

**Gmail not working?**
- Must use App Password (not regular password)
- Enable 2-Step Verification first
- Check "Less secure apps" is OFF

## That's It!

Once configured, your app will automatically:
- Send verification emails on registration
- Send password reset emails
- Send 2FA setup emails

No code changes needed - just configure SMTP!
