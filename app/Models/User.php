<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasRolesAndPermissions;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'phone',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function userApartments(): HasMany
    {
        return $this->hasMany(UserApartment::class);
    }

    public function apartments(): BelongsToMany
    {
        return $this->belongsToMany(Apartment::class, 'user_apartments')
                    ->withPivot(['occupancy_type', 'is_primary', 'start_date', 'end_date', 'status'])
                    ->withTimestamps();
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function assignedComplaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'assigned_to');
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class);
    }

    public function notices(): HasMany
    {
        return $this->hasMany(Notice::class, 'created_by');
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class);
    }
}
