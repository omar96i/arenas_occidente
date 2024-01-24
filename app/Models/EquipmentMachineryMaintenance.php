<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentMachineryMaintenance extends Model
{
    use HasFactory;

    protected $casts = [
        'activities' => 'array',
        'parts_amount_value' => 'array',
    ];

    protected $fillable = [
        'equipment_machinery_id',
        'code',
        'entry_date',
        'exit_date',
        'measure',
        'estimated_time',
        'real_time',
        'driver',
        'maintenance_type',
        'activities',
        'other_activities',
        'welding_activities',
        'description_corrective_maintenance',
        'elaborated_signature',
        'revised_signature',
        'file_evidence',
        'invoice_number',
        'parts_amount_value',
        'labor_value',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }
}
