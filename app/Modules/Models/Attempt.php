<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'started_at',
    ];

    /**
     * Get the entry of the attempt.
     *
     * @return BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo('App\Modules\Models\Entry');
    }

    /**
     * Get the answers during the attempt.
     *
     * @return HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Modules\Models\Answer');
    }
}
