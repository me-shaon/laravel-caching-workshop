<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'reason',
        'reported_by',
        'reported_user',
        'reviewed_by',
        'review_action',
        'review_notes',
        'reviewed_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function reportedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_user');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}