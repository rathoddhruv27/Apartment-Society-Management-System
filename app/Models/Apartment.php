<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'apartment_number',
        'floor_number',
        'type',
        'status',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function userApartments(): HasMany
    {
        return $this->hasMany(UserApartment::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_apartments')
                    ->withPivot(['occupancy_type', 'is_primary', 'start_date', 'end_date', 'status'])
                    ->withTimestamps();
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class);
    }
}
