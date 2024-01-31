<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentMachinerySoat extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_machinery_id',
        'name',
        'beneficiary',
        'validity',
        'status',
        'file'
    ];

    /**
     * Get the equipment_machinery that owns the EquipmentMachinerySoat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment_machinery(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }

    public function updateStatus(){
        if ($this->validity <= Carbon::now()) {
            $this->update(['status' => 'Expirado']);
        } else {
            $this->update(['status' => 'Vigente']);
        }
    }

}
