<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nit',
        'address',
        'phone',
        'contact',
        'bank',
        'number_bank',
    ];

    /**
     * Get all of the oils for the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oils(): HasMany
    {
        return $this->hasMany(OilSupplier::class);
    }

    /**
     * Get all of the consumable_suppliers for the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consumable_suppliers(): HasMany
    {
        return $this->hasMany(ConsumableSupplier::class);
    }
}
