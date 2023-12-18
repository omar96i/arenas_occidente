<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EquipmentMachinery extends Model
{
    use HasFactory;

    protected $casts = [
        'file_img' => 'array',
    ];

    protected $fillable = [
        'name',
        'description',
        'register_number',
        'file_img',
        'status',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(EquipmentMachineryValue::class);
    }

    public function maintenance(): HasMany
    {
        return $this->hasMany(EquipmentMachineryMaintenance::class);
    }

    /**
     * Get all of the schedulines for the EquipmentMachinery
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(MaintenanceScheduling::class, 'equipment_machinery_id');
    }

    /**
     * Get all of the oil_controls for the EquipmentMachinery
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oil_controls(): HasMany
    {
        return $this->hasMany(OilControl::class);
    }

    /**
     * Get the owner associated with the EquipmentMachinery
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner(): HasOne
    {
        return $this->hasOne(EquipmentMachineryOwner::class, 'equipment_machinery_id');
    }

    /**
     * Get all of the insurance for the EquipmentMachinery
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insurance(): HasMany
    {
        return $this->hasMany(EquipmentMachinerySure::class, 'equipment_machinery_id');
    }

    /**
     * Get all of the soats for the EquipmentMachinery
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function soats(): HasMany
    {
        return $this->hasMany(EquipmentMachinerySoat::class, 'equipment_machinery_id');
    }

    /**
     * Get all of the technos for the EquipmentMachinery
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function technos(): HasMany
    {
        return $this->hasMany(EquipmentMachineryTechno::class, 'equipment_machinery_id');
    }
}
