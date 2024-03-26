<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelControlSupply extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'file_evidence' => 'array',
    ];

    protected $fillable = [
        'date',
        'fuel_control_id',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if ($model->measure == 'LITROS') {
                $temp_amount = $model->convertLitersToGallons($model->amount);
            }
            // suma de control de combustible
            $fuel_control = FuelControl::find($model->fuel_control_id);
            $fuel_control->stock += $temp_amount;
            $fuel_control->save();

        });

        static::updating(function ($model) {

            $fuel_control = FuelControl::find($model->fuel_control_id);
            if ($fuel_control) {

                $original_amount = $model->getOriginal('amount');
                $original_measure = $model->getOriginal('measure');
                $new_amount = $model->amount;
                $new_measure = $model->measure;

                if ($original_measure == 'LITROS') {
                    $fuel_control->stock -= $model->convertLitersToGallons($original_amount);
                } else {
                    $fuel_control->stock -= $original_amount;
                }

                if ($new_measure == 'LITROS') {
                    $fuel_control->stock += $model->convertLitersToGallons($new_amount);
                } else {
                    $fuel_control->stock += $new_amount;
                }

                $fuel_control->save();
            }

        });

        static::deleting(function ($model) {

            if ($model->measure == 'LITROS') {
                $temp_amount = $model->convertLitersToGallons($model->amount);
            }

            $fuel_control = FuelControl::find($model->fuel_control_id);
            if ($fuel_control) {
                $fuel_control->stock -= $temp_amount;
                $fuel_control->save();
            }

        });
    }

    public function convertLitersToGallons($liters)
    {
        $gallons = 3.785;
        $gallons = $liters / $gallons;
        return $gallons;
    }
}
