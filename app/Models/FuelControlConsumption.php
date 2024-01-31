<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelControlConsumption extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'file_evidence' => 'array',
    ];

    protected $fillable = [
        'date',
        'is_external_source',
        'fuel_control_source_id',
        'fuel_control_id',
        'equipment_machinery_id',
        'horom_tanq',
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

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            if ($model->is_external_source) {
                // registro de abastecimiento si es de fuente externa
                $fuel_control_supply = new FuelControlSupply;
                $fuel_control_supply->fill([
                    'date' => $model->date,
                    'fuel_control_id' => $model->fuel_control_id,
                    'user_id' => $model->user_id,
                    'amount' => $model->amount,
                    'measure' => $model->measure,
                    'price' => $model->price,
                ]);
                $fuel_control_supply->save();
            }else{
                // resta de control de combustible
                $fuel_control = FuelControl::find($model->fuel_control_id);
                $fuel_control->stock -= $model->amount;
                $fuel_control->save();
            }
        });

        static::updating(function ($model) {
            if ($model->is_external_source) {
                // Actualización de registro de abastecimiento si es de fuente externa
                $fuel_control_supply = FuelControlSupply::where('fuel_control_id', $model->fuel_control_id)
                    ->where('date', $model->date)
                    ->where('user_id', $model->user_id)
                    ->first();
        
                if ($fuel_control_supply) {
                    $fuel_control_supply->update([
                        'amount' => $model->amount,
                        'measure' => $model->measure,
                        'price' => $model->price,
                    ]);
                }
            } else {
                // Actualización de resta de control de combustible
                $fuel_control = FuelControl::find($model->fuel_control_id);
        
                if ($fuel_control) {
                    $fuel_control->stock += $model->getOriginal('amount'); // Restaurar el valor original
                    $fuel_control->stock -= $model->amount;
                    $fuel_control->save();
                }
            }
        });
    }
}
