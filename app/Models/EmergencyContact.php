<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'designation',
        'phone',
        'alt_phone',
        'is_facility_contact',
    ];

    protected function casts(): array
    {
        return [
            'is_facility_contact' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
