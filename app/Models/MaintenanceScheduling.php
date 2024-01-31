<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function updateStatus()
    {   
        $today = Carbon::now();
        $days = $today->diffInDays(Carbon::parse($this->date), false);
        
        if ($days < 0) {
            $this->status = 'PASADO';
        } elseif ($days < 7) {
            $this->status = 'PROXIMO';
        } else {
            $this->status = 'BUEN ESTADO';
        }

        $this->save();
        
    }
}
