<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consumable extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'stock',
    ];

    /**
     * Get all of the consumable_control for the Consumable
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consumable_controls(): HasMany
    {
        return $this->hasMany(ConsumableControl::class);
    }

    /**
     * Get all of the consumable_suppliers for the Consumable
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consumable_suppliers(): HasMany
    {
        return $this->hasMany(ConsumableSupplier::class);
    }


}
