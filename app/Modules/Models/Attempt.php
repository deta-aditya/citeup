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
        'entry_id', 'started_at',
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

    /**
     * Scope a query to only include attempts of the given entry.
     *
     * @param  Builder  $query
     * @param  int      $entry
     * @return Builder
     */
    public function scopeOfEntry($query, $entry)
    {
        return $query->whereHas('entry', function ($query) use ($entry) {
            $query->where('entry_id', $entry);
        });
    }

    /**
     * Scope a query to only include finished attempts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFinished($query)
    {
        return $query->whereNotNull('finished_at');
    }

    /**
     * Scope a query to only include unfinished attempts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeUnfinished($query)
    {
        return $query->whereNull('finished_at');
    }
}
