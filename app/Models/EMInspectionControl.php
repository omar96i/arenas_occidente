<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EMInspectionControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_machinery_id',
        'last_report',
        'actual_report',
        'next_report',
        'hourometer',
        'frequency',
        'unit',
        'status',
        'extinguisher_expiration',
        'extinguisher_status',
        'installed_board',
        'installed_board_id',
        'installed_board_status',
    ];

    /**
     * Get the equipment_machinery that owns the EquipmentMachineryInspectionControl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment_machinery(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }
}
