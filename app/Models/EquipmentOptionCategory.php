<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentOptionCategory extends Model
{
    use HasFactory;

    protected $table = "equipment_option_categories";

    protected $fillable = [
        'name',
    ];

    /**
     * Get all of the options for the EquimentOptionCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options(): HasMany
    {
        return $this->hasMany(EquipmentOption::class, 'equipment_option_category_id');
    }
}
