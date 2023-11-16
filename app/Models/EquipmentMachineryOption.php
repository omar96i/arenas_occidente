<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentMachineryOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_machinery_categories_id',
        'name',
    ];

    /**
     * Get all of the equiments for the EquimentOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(EquipmentMachineryValue::class, 'equipment_machinery_option_id');
    }

    /**
     * Get the category that owns the EquimentOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachineryCategory::class, 'equipment_machinery_categories_id');
    }
}
