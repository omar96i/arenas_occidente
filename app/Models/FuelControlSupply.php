<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelControlSupply extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'file_evidence' => 'array',
    ];

    protected $fillable = [
        'date',
        'fuel_control_source_id',
        'equipment_machinery_id',
        'fuel_control_id',
        'user_id',
        'amount',
        'measure',
        'price',
        'file_evidence',
    ];

    public function tank(): BelongsTo
    {
        return $this->belongsTo(FuelControl::class, 'fuel_control_id');
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function origin(): BelongsTo
    {
        return $this->belongsTo(FuelControlSource::class, 'fuel_control_source_id');
    }
}
