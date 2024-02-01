<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsumableControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'consumable_id',
        'user_id',
        'equipment_machinery_id',
        'amount',
        'date',
    ];

    /**
     * Get the equipment_machinery that owns the ConsumableControl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment_machinery(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class);
    }

    /**
     * Get the user that owns the ConsumableControl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the consumable that owns the ConsumableControl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consumable(): BelongsTo
    {
        return $this->belongsTo(Consumable::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $amount = $model->amount;
            $consumable = Consumable::where('id', $model->consumable_id)->first();
            $consumable->decrement('stock', $amount);
            $consumable->save();
        });

        static::updating(function ($model) {
            $original = $model->getOriginal();

            $consumable = Consumable::where('id', $original['consumable_id'])->first();
            $consumable->increment('stock', $original['amount']);
            $consumable->save();

            $consumable->decrement('stock', $model->amount);
            $consumable->save();
        });

        static::deleting(function ($model) {
            $consumable = Consumable::where('id', $model->consumable_id)->first();
            $consumable->increment('stock', $model->amount);
            $consumable->save();
        });
    }
}
