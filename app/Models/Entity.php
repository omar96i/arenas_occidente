<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get all of the measures for the Entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function measures(): HasMany
    {
        return $this->hasMany(EntityMeasure::class);
    }

    /**
     * Get all of the segments for the Entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function segments(): HasMany
    {
        return $this->hasMany(EntitySegment::class);
    }
}
