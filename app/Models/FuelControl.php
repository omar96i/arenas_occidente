<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelControl extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'stock',
        'type',
        'measure',
    ];

    public function consumption(): HasMany
    {
        return $this->hasMany(FuelControlConsumption::class, 'fuel_control_id');
    }

    public function supply(): HasMany
    {
        return $this->hasMany(FuelControlSupply::class, 'fuel_control_id');
    }
}
