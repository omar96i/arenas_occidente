<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentOption extends Model
{
    use HasFactory;

    protected $table = "equipment_options";

    protected $fillable = [
        'equipment_option_category_id',
        'name',
    ];

    /**
     * Get all of the equiments for the EquimentOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(EquipmentEquipmentOption::class, 'equipment_option_id');
    }

    /**
     * Get the category that owns the EquimentOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentOptionCategory::class, 'equipment_option_category_id');
    }
}
