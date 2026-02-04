# ✅ Email Setup Checklist

## Pre-Setup (Already Done ✅)

- [x] Email verification routes configured
- [x] Email verification controller created
- [x] Password reset controller created
- [x] User model implements MustVerifyEmail
- [x] Email views created
- [x] `.env` file configured for Gmail SMTP
- [x] Activity logging for email events

## Your Tasks (3 Simple Steps)

### ☐ Step 1: Enable 2-Step Verification

1. Go to: https://myaccount.google.com/security
2. Find "2-Step Verification"
3. Click "Get Started" and follow the prompts
4. Complete the setup

**Status:** ☐ Not Started | ☐ In Progress | ☐ Complete

---

### ☐ Step 2: Generate Gmail App Password

1. Go to: https://myaccount.google.com/apppasswords
2. Select "Mail" as the app
3. Select "Other (Custom name)" as the device
4. Name it: "Password Manager"
5. Click "Generate"
6. Copy the 16-character password

**Your App Password:** `________________` (write it down)

**Status:** ☐ Not Started | ☐ In Progress | ☐ Complete

---

### ☐ Step 3: Update `.env` File

Open `.env` and update these lines:

```env
MAIL_USERNAME=your-gmail@gmail.com          ← Replace with your Gmail
MAIL_PASSWORD=your-16-char-app-password     ← Replace with App Password
MAIL_FROM_ADDRESS="your-gmail@gmail.com"    ← Replace with your Gmail
```

**Example:**
```env
MAIL_USERNAME=john.doe@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_FROM_ADDRESS="john.doe@gmail.com"
```

**Status:** ☐ Not Started | ☐ In Progress | ☐ Complete

---

### ☐ Step 4: Clear Configuration Cache

Run in terminal:

```bash
php artisan config:clear
```

**Status:** ☐ Not Started | ☐ Complete

---

## Testing Checklist

### ☐ Test 1: Quick Email Test

Run:
```bash
php artisan tinker < test-email.php
```

**Expected Result:** `✅ Test email sent successfully!`

**Status:** ☐ Not Started | ☐ Passed | ☐ Failed

---

### ☐ Test 2: Registration Email Verification

1. Go to: http://localhost:8000/register
2. Register a new user
3. Check email inbox
4. Click verification link
5. Verify redirect to dashboard

**Status:** ☐ Not Started | ☐ Passed | ☐ Failed

---

### ☐ Test 3: Password Reset Email

1. Go to: http://localhost:8000/login
2. Click "Forgot Password?"
3. Enter email address
4. Check email inbox
5. Click reset link
6. Set new password
7. Login with new password

**Status:** ☐ Not Started | ☐ Passed | ☐ Failed

---

## Troubleshooting Checklist

If emails are not sending, check:

- [ ] 2-Step Verification is enabled on Gmail
- [ ] App Password is correct (no spaces)
- [ ] Using App Password, not regular Gmail password
- [ ] `.env` file has correct Gmail address
- [ ] Ran `php artisan config:clear` after updating `.env`
- [ ] No errors in `storage/logs/laravel.log`
- [ ] Gmail "Sent" folder shows sent emails
- [ ] Checked "Spam" folder for received emails

---

## Success Criteria

You're done when:

- ✅ Test email command works
- ✅ Registration sends verification email
- ✅ Verification link redirects to dashboard
- ✅ Password reset email arrives
- ✅ Reset link works and updates password
- ✅ No errors in Laravel logs

---

## Quick Reference

**Gmail App Passwords:** https://myaccount.google.com/apppasswords

**Gmail Security:** https://myaccount.google.com/security

**Clear Cache Command:** `php artisan config:clear`

**Test Email Command:** `php artisan tinker < test-email.php`

**View Logs:** `tail -n 50 storage/logs/laravel.log`

---

## Files to Check

- `.env` - Your email configuration
- `storage/logs/laravel.log` - Error logs
- `app/Http/Controllers/Auth/RegisterController.php` - Registration logic
- `app/Http/Controllers/Auth/EmailVerificationController.php` - Verification logic
- `app/Http/Controllers/Auth/PasswordResetController.php` - Reset logic

---

## Support

**Detailed Guide:** See `GMAIL_SMTP_SETUP_GUIDE.md`

**Quick Start:** See `QUICK_START_EMAIL.md`

**Test Script:** Run `test-email.php`

---

**Last Updated:** February 4, 2026

**Status:** Ready for Gmail SMTP configuration ✅
