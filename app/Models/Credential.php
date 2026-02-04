<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credential extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'website_name',
        'website_url',
        'username_email',
        'encrypted_password',
        'encrypted_notes',
        'encryption_iv',
        'is_favorite',
        'password_updated_at',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
        'password_updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
