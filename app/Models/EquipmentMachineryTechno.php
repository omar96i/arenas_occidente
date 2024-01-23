<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentMachineryTechno extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_machinery_id',
        'technomechanical',
        'date_tuition',
        'last_revision',
        'date_revision',
        'file',
        'status',
    ];

    /**
     * Get the equipment_machinary that owns the EquipmentMachinaryTechno
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment_machinery(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }
}
