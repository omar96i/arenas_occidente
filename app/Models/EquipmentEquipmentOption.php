<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentEquipmentOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'equipment_option_id',
        'value',
    ];

    /**
     * Get the equiment that owns the EquimentEquimentOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    /**
     * Get the option that owns the EquimentEquimentOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option(): BelongsTo
    {
        return $this->belongsTo(EquipmentOption::class, 'equipment_option_id');
    }
}
