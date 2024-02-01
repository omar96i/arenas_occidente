<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsumableSupplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'consumable_id',
        'supplier_id',
        'price',
        'amount',
        'file',
    ];

    /**
     * Get the consumable that owns the ConsumableSupplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consumable(): BelongsTo
    {
        return $this->belongsTo(Consumable::class);
    }

    /**
     * Get the supplier that owns the ConsumableSupplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $stock = $model->amount;
            $consumable = Consumable::where('id', $model->consumable_id)->first();
            $consumable->increment('stock', $stock);
            $consumable->save();
        });

        static::updating(function ($model) {
            $original = $model->getOriginal();

            $consumable = Consumable::where('id', $original['consumable_id'])->first();
            $consumable->decrement('stock', $original['amount']);
            $consumable->save();

            $consumable->increment('stock', $model->amount);
            $consumable->save();
        });

        static::deleting(function ($model) {
            $oil = Consumable::where('id', $model->consumable_id)->first();
            $oil->decrement('stock', $model->amount);
            $oil->save();
        });
    }
}
