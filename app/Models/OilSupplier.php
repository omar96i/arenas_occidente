<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OilSupplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'oil_id',
        'supplier_id',
        'mark',
        'stock',
        'price',
        'file',
    ];
    // Relations
    /**
     * Get the oil that owns the OilSupplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function oil(): BelongsTo
    {
        return $this->belongsTo(Oil::class);
    }

    /**
     * Get the supplier that owns the OilSupplier
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
            $stock = $model->stock;
            $oil = Oil::where('id', $model->oil_id)->first();
            $oil->increment('stock', $stock);
            $oil->save();
        });

        static::updating(function ($model) {
            $original = $model->getOriginal();

            $oil = Oil::where('id', $original['oil_id'])->first();
            $oil->decrement('stock', $original['stock']);
            $oil->save();

            $oil->increment('stock', $model->stock);
            $oil->save();
        });

        static::deleting(function ($model) {
            $oil = Oil::where('id', $model->oil_id)->first();
            $oil->decrement('stock', $model->stock);
            $oil->save();
        });
    }
}
