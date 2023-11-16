<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentMachineryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(EquipmentMachineryOption::class, 'equipment_machinery_categories_id');
    }
}
