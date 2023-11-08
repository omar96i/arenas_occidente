<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityShift extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'entity_segment_id',
        'user_id',
        'entity_measure_id',
        'date',
    ];

    /**
     * Get the segment that owns the EntityShift
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segment(): BelongsTo
    {
        return $this->belongsTo(EntitySegment::class, 'entity_segment_id');
    }

    /**
     * Get the user that owns the EntityShift
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the measure that owns the EntityShift
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function measure(): BelongsTo
    {
        return $this->belongsTo(EntityMeasure::class, 'entity_measure_id');
    }
}
