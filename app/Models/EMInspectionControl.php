<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EMInspectionControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_machinery_id',
        'last_report',
        'actual_report',
        'next_report',
        'hourometer',
        'frequency',
        'unit',
        'status',
        'extinguisher_expiration',
        'extinguisher_status',
    ];

    /**
     * Get the equipment_machinery that owns the EquipmentMachineryInspectionControl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment_machinery(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }

    public function updateStatus()
    {
        if (is_null($this->last_report)) {
            $last_report = Carbon::now();
        } else {
            $last_report = Carbon::parse($this->last_report);
        }
        
        $new_date = $last_report->addDays($this->frequency);
        $this->next_report = $new_date->format('Y-m-d');
        
        $today = now();
        $days = $today->diffInDays($new_date, false);
        
        if ($days < 0) {
            $this->status = 'PASADO';
        } elseif ($days < 7) {
            $this->status = 'PROXIMO';
        } else {
            $this->status = 'BUEN ESTADO';
        }

        $this->save();
    }

    public function updateExtinguisherStatus()
    {   
        $today = now();
        $days = $today->diffInDays(Carbon::parse($this->extinguisher_expiration), false);
        
        if ($days < 0) {
            $this->extinguisher_status = 'PASADO';
        } elseif ($days < 7) {
            $this->extinguisher_status = 'PROXIMO';
        } else {
            $this->extinguisher_status = 'BUEN ESTADO';
        }

        $this->save();
    }


}
