<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Oil extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type_oil',
        'stock',
    ];

    /**
     * Get all of the suppliers for the Oil
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(OilSupplier::class);
    }

    /**
     * Get all of the oil_controls for the Oil
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oil_controls(): HasMany
    {
        return $this->hasMany(OilControl::class);
    }
}
