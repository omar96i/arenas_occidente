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

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            // Incrementar el stock al crear un registro de control
            $amount = $model->amount;
            $oil = Oil::where('id', $model->oil_id)->first();
            $oil->decrement('stock', $amount);
            $oil->save();
        });

        static::updating(function ($model) {
            // Obtén el modelo original antes de la actualización
            $original = $model->getOriginal();

            // Incrementa el valor original antes de aplicar la nueva disminución
            $oil = Oil::where('id', $original['oil_id'])->first();
            $oil->increment('stock', $original['amount']);
            $oil->save();

            // Ahora decrementa con el nuevo valor
            $oil->decrement('stock', $model->amount);
            $oil->save();
        });

        static::deleting(function ($model) {
            // Incrementa el valor cuando se elimina el registro
            $oil = Oil::where('id', $model->oil_id)->first();
            $oil->increment('stock', $model->amount);
            $oil->save();
        });
    }

}
