# Export Feature - Password Decryption Fix

## Overview
The export feature has been updated to properly handle password decryption and provide better error messages when decryption fails.

## How Export Works

### Current Implementation
The ExportController **already decrypts passwords** before exporting. Here's the flow:

1. **User Authentication**: Requires current password to export
2. **Fetch Credentials**: Gets all user credentials from database
3. **Decrypt Passwords**: Decrypts each password using EncryptionService
4. **Decrypt Notes**: Decrypts notes if they exist
5. **Format Data**: Formats as JSON or CSV
6. **Optional Encryption**: Can encrypt export file with export password
7. **Download**: Returns file for download

### Decryption Process
```php
$password = $this->encryption->decrypt(
    $credential->encrypted_password,
    $credential->encryption_iv
);
```

## Export Formats

### JSON Export
```json
{
  "exported_at": "2026-02-03 12:00:00",
  "user": {
    "name": "John Doe",
    "email": "john@example.com"
  },
  "credentials": [
    {
      "website_name": "GitHub",
      "website_url": "https://github.com",
      "username_email": "john@example.com",
      "password": "MyActualPassword123!",  ← DECRYPTED
      "category": "Work",
      "notes": "My work account",
      "is_favorite": true,
      "created_at": "2026-01-15 10:30:00"
    }
  ]
}
```

### CSV Export
```csv
Website,URL,Username/Email,Password,Category,Notes,Favorite,Created At
"GitHub","https://github.com","john@example.com","MyActualPassword123!","Work","My work account","Yes","2026-01-15 10:30:00"
```

## Error Handling

### Updated Behavior
If decryption fails for any credential:
- **Before**: Credential was skipped (not included in export)
- **After**: Credential is included with `[DECRYPTION FAILED]` message
- **Logging**: Error is logged to Laravel log file

### Why Decryption Might Fail
1. **Corrupted Data**: Encrypted password or IV is corrupted
2. **Wrong Encryption Key**: APP_KEY has changed since encryption
3. **Database Issues**: Data truncated or modified

## Testing the Export

### Test 1: Basic Export
1. Go to Settings → Export Data
2. Enter your current password
3. Select format (JSON or CSV)
4. Leave "Export Password" empty
5. Click "Export Credentials"
6. **Expected**: File downloads with decrypted passwords

### Test 2: Encrypted Export
1. Go to Settings → Export Data
2. Enter your current password
3. Select format (JSON or CSV)
4. Enter an "Export Password" (min 12 characters)
5. Click "Export Credentials"
6. **Expected**: File downloads with `.enc` extension
7. **Note**: File is encrypted and needs export password to decrypt

### Test 3: Verify Decrypted Passwords
1. Export as JSON (no export password)
2. Open the downloaded JSON file
3. Look at the "password" field
4. **Expected**: Should show actual password like "MyPassword123!"
5. **Not Expected**: Should NOT show encrypted text like "LxOYJrczvzrcVNev+PMy8rZIHh0f99xhExQa+yH9cHg="

## Troubleshooting

### Issue: Passwords Still Encrypted
**Symptoms**: Export shows encrypted text instead of actual passwords

**Possible Causes**:
1. Export file is encrypted (has `.enc` extension)
2. Decryption is failing (check logs)
3. APP_KEY has changed

**Solutions**:
1. If file is `.enc`, you need the export password to decrypt it
2. Check `storage/logs/laravel.log` for decryption errors
3. Verify APP_KEY hasn't changed in `.env`

### Issue: [DECRYPTION FAILED] in Export
**Symptoms**: Some credentials show `[DECRYPTION FAILED]`

**Cause**: Those specific credentials couldn't be decrypted

**Solutions**:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Look for error messages about those credentials
3. May need to re-save those credentials

### Issue: Export File is Empty
**Symptoms**: No credentials in export file

**Possible Causes**:
1. No credentials in database
2. All credentials failed to decrypt

**Solutions**:
1. Check if you have credentials in dashboard
2. Check Laravel logs for errors
3. Try creating a new test credential and exporting

## Security Features

### Export Password Protection
When you provide an "Export Password":
1. **Encryption**: Entire export file is encrypted with AES-256-CBC
2. **Key Derivation**: Export password is hashed with SHA-256
3. **IV**: Random 16-byte initialization vector
4. **Format**: Base64-encoded (IV + encrypted data)

### Decrypting Protected Export
To decrypt a `.enc` file:
```php
// Decode base64
$decoded = base64_decode($encryptedFile);

// Extract IV (first 16 bytes)
$iv = substr($decoded, 0, 16);

// Extract encrypted data
$encrypted = substr($decoded, 16);

// Derive key from export password
$key = hash('sha256', $exportPassword, true);

// Decrypt
$decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
```

## Activity Logging

Every export is logged:
```
Action: data_exported
User ID: 1
IP Address: 192.168.1.100
Timestamp: 2026-02-03 12:00:00
```

## Best Practices

### For Users
1. **Use Export Password**: Always encrypt exports for security
2. **Store Safely**: Keep export files in secure location
3. **Delete After Use**: Remove export files when no longer needed
4. **Strong Export Password**: Use 12+ characters with mixed case, numbers, symbols

### For Developers
1. **Never Log Passwords**: Don't log decrypted passwords
2. **Secure Transmission**: Use HTTPS for downloads
3. **Validate Input**: Always validate export password strength
4. **Error Handling**: Handle decryption failures gracefully

## Files Modified

1. **app/Http/Controllers/ExportController.php**
   - Added better error handling
   - Added logging for decryption failures
   - Include failed credentials with error message

## Verification Steps

1. **Create Test Credential**:
   - Go to Dashboard
   - Add new credential with password "TestPassword123!"
   - Save it

2. **Export Data**:
   - Go to Settings → Export Data
   - Enter your password
   - Select JSON format
   - Don't use export password
   - Click Export

3. **Check Export File**:
   - Open downloaded JSON file
   - Find your test credential
   - Verify password shows "TestPassword123!"
   - NOT encrypted text

4. **Check Logs** (if issues):
   - Open `storage/logs/laravel.log`
   - Look for "Export decryption failed" messages
   - Check error details

## Status
✅ **WORKING** - Export feature properly decrypts passwords before exporting. If you're seeing encrypted text, check the troubleshooting section above.
