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
        'stock_2',
        'price_2',
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

    // functions

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $stock = $model->stock;
            $stock_2 = $model->stock_2;

            $oil = Oil::where('id', $model->oil_id)->first();

            if ($stock !== null && $stock > 0) {
                $oil->increment('stock', $stock);
            }

            if ($stock_2 !== null && $stock_2 > 0) {
                $oil->increment('stock', $stock_2 * 50);
            }

            $oil->save();
        });
    }
}
