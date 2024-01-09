<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentMachineryLabor extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_machinery_id',
        'date',
        'entry_time',
        'departure_time',
        'status',
        'user_id',
        'location',
        'entity_id',
        'activity',
        'hr_ini',
        'hr_fin',
        'hr_lab',
        'trips',
        'ton',
        'state_fact',
        'observations',
    ]; 

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->where('position', 'conductor');
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }
}
