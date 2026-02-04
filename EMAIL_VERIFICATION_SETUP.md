# Email Verification Setup Guide

## Overview
This guide will help you set up SMTP email verification for:
- User registration email verification
- Password reset emails
- 2FA setup emails

## Step 1: Configure SMTP Settings

### Option A: Using Gmail (Recommended for Testing)

1. **Enable 2-Step Verification** on your Gmail account
2. **Generate App Password**:
   - Go to: https://myaccount.google.com/apppasswords
   - Select "Mail" and "Other (Custom name)"
   - Name it "Password Manager"
   - Copy the 16-character password

3. **Update `.env` file**:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Password Manager"
```

### Option B: Using Mailtrap (Recommended for Development)

1. **Sign up** at https://mailtrap.io (Free)
2. **Get credentials** from your inbox
3. **Update `.env` file**:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@passwordmanager.com
MAIL_FROM_NAME="Password Manager"
```

### Option C: Using SendGrid (Recommended for Production)

1. **Sign up** at https://sendgrid.com
2. **Create API Key**
3. **Update `.env` file**:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Password Manager"
```

## Step 2: Clear Configuration Cache

After updating `.env`, run:
```bash
php artisan config:clear
php artisan cache:clear
```

## Step 3: Test Email Configuration

Create a test route to verify emails are working:

```bash
php artisan tinker
```

Then run:
```php
Mail::raw('Test email from Password Manager', function($message) {
    $message->to('your-test-email@example.com')
            ->subject('Test Email');
});
```

## Step 4: How It Works

### Registration Flow:
1. User registers → Email verification sent automatically
2. User clicks verification link in email
3. Email is verified → User can access dashboard

### Password Reset Flow:
1. User clicks "Forgot Password"
2. Enters email → Reset link sent
3. User clicks link → Can set new password

### Current Implementation Status:
✅ Email verification routes configured
✅ Email verification controller ready
✅ Password reset routes configured
✅ Password reset controller ready
✅ Email verification views created
✅ Password reset views created

## Step 5: Verify Routes

Your app already has these routes configured:

**Email Verification:**
- GET `/email/verify` - Verification notice
- GET `/email/verify/{id}/{hash}` - Verify email
- POST `/email/verification-notification` - Resend verification

**Password Reset:**
- GET `/forgot-password` - Request form
- POST `/forgot-password` - Send reset link
- GET `/reset-password/{token}` - Reset form
- POST `/reset-password` - Update password

## Step 6: Testing

### Test Email Verification:
1. Register a new account
2. Check your email inbox (or Mailtrap)
3. Click verification link
4. Should redirect to dashboard

### Test Password Reset:
1. Go to login page
2. Click "Forgot Password?"
3. Enter your email
4. Check email for reset link
5. Click link and set new password

## Troubleshooting

### Emails not sending?
1. Check `.env` configuration
2. Run `php artisan config:clear`
3. Check `storage/logs/laravel.log` for errors
4. Verify SMTP credentials are correct

### Gmail blocking emails?
1. Enable "Less secure app access" (not recommended)
2. Use App Password instead (recommended)
3. Check Gmail's "Blocked" folder

### Mailtrap not receiving?
1. Verify you're using correct inbox credentials
2. Check Mailtrap dashboard for caught emails
3. Emails appear instantly in Mailtrap

## Production Recommendations

1. **Use a dedicated email service**:
   - SendGrid (99,000 free emails/month)
   - Mailgun (5,000 free emails/month)
   - Amazon SES (62,000 free emails/month)

2. **Set up SPF and DKIM records** for your domain

3. **Use a professional email address**:
   - `noreply@yourdomain.com`
   - `support@yourdomain.com`

4. **Monitor email delivery rates**

5. **Set up email templates** for branding

## Security Notes

- ✅ Email verification links are signed and expire
- ✅ Password reset tokens expire after 60 minutes
- ✅ One-time use tokens (can't be reused)
- ✅ Rate limiting on password reset requests
- ✅ HTTPS required for production

## Next Steps

1. Choose your SMTP provider
2. Update `.env` with credentials
3. Clear cache
4. Test registration
5. Test password reset
6. Deploy to production

## Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify SMTP credentials
3. Test with Mailtrap first
4. Check firewall/port settings
