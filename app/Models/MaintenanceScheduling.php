<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceScheduling extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_machinery_id',
        'date',
        'description',
        'status',
        'user_id',
        'mileage',
        'hourometer',
    ];

    /**
     * Get the equipment that owns the MaintenanceScheduling
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }

    /**
     * Get the user that owns the MaintenanceScheduling
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
