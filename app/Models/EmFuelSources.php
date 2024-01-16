<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmFuelSources extends Model
{
    use HasFactory;

    protected $casts = [
        'is_equipment' => 'boolean',
    ];

    protected $fillable = [
        'is_equipment',
        'equipment_machinery_id',
        'name',
    ];


    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }
}

