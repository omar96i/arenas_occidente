<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OilControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'oil_id',
        'equipment_machinery_id',
        'date',
        'area',
        'amount',
    ];

    /**
     * Get the applicant that owns the OilControl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the oil that owns the OilControl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function oil(): BelongsTo
    {
        return $this->belongsTo(Oil::class);
    }

    /**
     * Get the equipment_machinery that owns the OilControl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment_machinery(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }

}
