# 2FA Testing Checklist

## Prerequisites
- Ensure database is running
- Ensure application is running (e.g., `php artisan serve` or Herd)
- Have a test user account ready
- Have Google Authenticator or similar TOTP app installed on your phone

## Test Scenarios

### ✅ Scenario 1: Enable 2FA
1. Login to your account
2. Navigate to Settings page
3. Click "Enable Two-Factor Authentication"
4. **Expected**: QR code and secret key are displayed
5. Scan QR code with authenticator app
6. Enter the 6-digit code from the app
7. Click "Confirm"
8. **Expected**: Recovery codes are displayed (8 codes)
9. Save the recovery codes in a safe place
10. **Expected**: Redirected back to settings with success message

### ✅ Scenario 2: Login with 2FA (TOTP Code)
1. Logout from your account
2. Go to login page
3. Enter your email and password
4. Click "Login"
5. **Expected**: Redirected to 2FA verification page (NOT dashboard)
6. Open your authenticator app
7. Enter the current 6-digit code
8. Click "Verify"
9. **Expected**: Redirected to dashboard with success message
10. **Expected**: Can access all features normally

### ✅ Scenario 3: Login with 2FA (Recovery Code)
1. Logout from your account
2. Go to login page
3. Enter your email and password
4. Click "Login"
5. **Expected**: Redirected to 2FA verification page
6. Enter one of your recovery codes (10 characters)
7. Click "Verify"
8. **Expected**: Redirected to dashboard with success message
9. **Note**: This recovery code is now used and cannot be reused

### ✅ Scenario 4: Invalid 2FA Code
1. Logout from your account
2. Go to login page
3. Enter your email and password
4. Click "Login"
5. **Expected**: Redirected to 2FA verification page
6. Enter an invalid code (e.g., "000000")
7. Click "Verify"
8. **Expected**: Error message "Invalid verification code"
9. **Expected**: Remain on 2FA verification page

### ✅ Scenario 5: Session Expiry on 2FA Page
1. Logout from your account
2. Go to login page
3. Enter your email and password
4. Click "Login"
5. **Expected**: Redirected to 2FA verification page
6. Wait for session to expire (or clear cookies)
7. Try to enter a code
8. **Expected**: Error message about session expiry
9. **Expected**: Redirected to login page

### ✅ Scenario 6: Direct Dashboard Access (Bypass Attempt)
1. Logout from your account
2. Manually navigate to `/dashboard` in browser
3. **Expected**: Redirected to login page
4. Login with email and password
5. **Expected**: Redirected to 2FA verification page (NOT dashboard)
6. Try to manually navigate to `/dashboard` again
7. **Expected**: Redirected back to 2FA verification page
8. Complete 2FA verification
9. **Expected**: Now can access dashboard

### ✅ Scenario 7: Login Without 2FA
1. Create a new user account (or use existing account without 2FA)
2. Ensure 2FA is NOT enabled for this account
3. Logout if logged in
4. Go to login page
5. Enter email and password
6. Click "Login"
7. **Expected**: Redirected DIRECTLY to dashboard (no 2FA page)
8. **Expected**: Can access all features normally

### ✅ Scenario 8: Disable 2FA
1. Login to account with 2FA enabled (complete 2FA verification)
2. Navigate to Settings page
3. Scroll to Two-Factor Authentication section
4. Enter your password in the "Disable 2FA" form
5. Click "Disable Two-Factor Authentication"
6. **Expected**: Success message "2FA has been disabled"
7. Logout
8. Login again
9. **Expected**: Redirected DIRECTLY to dashboard (no 2FA page)

### ✅ Scenario 9: Regenerate Recovery Codes
1. Login to account with 2FA enabled
2. Navigate to Settings page
3. Scroll to Two-Factor Authentication section
4. Enter your password in the "Regenerate Recovery Codes" form
5. Click "Regenerate Recovery Codes"
6. **Expected**: New set of 8 recovery codes displayed
7. **Note**: Old recovery codes are now invalid

### ✅ Scenario 10: Multiple Login Attempts
1. Logout from your account
2. Try to login with wrong password 5 times
3. **Expected**: Rate limiting message appears
4. Wait for the specified time
5. Login with correct credentials
6. **Expected**: Redirected to 2FA verification page
7. Complete 2FA verification
8. **Expected**: Successfully logged in

## Expected Behavior Summary

| User Type | Login Flow |
|-----------|-----------|
| No 2FA | Login → Dashboard |
| With 2FA | Login → 2FA Verify → Dashboard |
| Invalid Credentials | Login → Error Message |
| Invalid 2FA Code | 2FA Verify → Error Message |

## Security Checks

- [ ] Cannot access dashboard without 2FA verification
- [ ] Cannot access any protected routes without 2FA verification
- [ ] Session is regenerated after successful 2FA verification
- [ ] Recovery codes are one-time use only
- [ ] Used recovery codes are removed from the list
- [ ] 2FA session data is cleared after successful verification
- [ ] 2FA session data is cleared on logout
- [ ] Rate limiting works on login attempts
- [ ] Activity logs record all 2FA events

## Common Issues and Solutions

### Issue: "Session expired" on 2FA page
**Solution**: Return to login page and start again

### Issue: Invalid verification code (but code is correct)
**Solution**: Check device time synchronization

### Issue: Lost authenticator app
**Solution**: Use recovery codes to login, then disable and re-enable 2FA

### Issue: All recovery codes used
**Solution**: Login with TOTP code, then regenerate recovery codes

## Files to Monitor

- `storage/logs/laravel.log` - Check for any errors
- Activity logs in database - Verify events are logged
- Session data - Ensure proper cleanup

## Performance Checks

- [ ] Login page loads quickly
- [ ] 2FA verification page loads quickly
- [ ] QR code generation is fast
- [ ] Code verification is instant
- [ ] No unnecessary database queries

## Status
All test scenarios should pass. If any scenario fails, check the implementation files and logs.
