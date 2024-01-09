<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentMachineryFuel extends Model
{
    use HasFactory;

    protected $casts = [
        'file_img' => 'array',
    ];

    protected $fillable = [
        'date',
        'equipment_machinery_id',
        'acpm',
        'horom_tanq',
        'source',
        'consecutive_ing',
        'file_img',
        'user_id',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
