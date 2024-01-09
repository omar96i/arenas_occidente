<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'full_name',
        'last_name',
        'document',
        'address',
        'position'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(UserContract::class);
    }

    public function contract_active(): HasOne
    {
        return $this->hasOne(UserContract::class)->where('status', true);
    }

    /**
     * Get all of the shifts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shifts(): HasMany
    {
        return $this->hasMany(EntityShift::class);
    }

    /**
     * Get all of the oil_applicants for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oil_applicants(): HasMany
    {
        return $this->hasMany(OilControl::class, 'user_id');
    }

    /**
     * Get all of the labors for the User with position driver
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labors(): HasMany
    {
        return $this->hasMany(EquipmentMachineryLabor::class, 'user_id');
    }
}
