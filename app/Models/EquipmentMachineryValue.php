<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentMachineryValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_machinery_id',
        'equipment_machinery_option_id',
        'value',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachineryOption::class, 'equipment_machinery_option_id');
    }
}
