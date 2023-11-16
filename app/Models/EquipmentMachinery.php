<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentMachinery extends Model
{
    use HasFactory;

    protected $casts = [
        'file_img' => 'array',
    ];

    protected $fillable = [
        'name',
        'description',
        'register_number',
        'file_img',
        'status',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(EquipmentMachineryValue::class);
    }

    public function maintenance(): HasMany
    {
        return $this->hasMany(EquipmentMachineryMaintenance::class);
    }
}
