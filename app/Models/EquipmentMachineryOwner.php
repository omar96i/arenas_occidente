<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentMachineryOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_machinery_id',
        'full_name',
        'nit',
        'tuition',
        'file'
    ];

    /**
     * Get the equipment_machinery that owns the EquipmentMachineryOwner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment_machinery(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }
}
