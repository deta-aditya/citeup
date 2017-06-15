<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Contracts\Models\Editable;

class Schedule extends Model implements Editable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_id', 'held_at', 'description',
    ];

    /**
     * Get the activity of the schedule.
     *
     * @return BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo('App\Modules\Models\Activity');
    }

    /**
     * Get all of the schedule's tracked edits.
     *
     * @return MorphMany
     */
    public function edits()
    {
        return $this->morphMany('App\Modules\Models\Edit', 'editable');
    }

    /**
     * Scope a query to only include schedules of the given activity.
     *
     * @param  Builder  $query
     * @param  int      $activity
     * @return Builder
     */
    public function scopeOfActivity($query, $activity)
    {
        return $query->where('activity_id', $activity);
    }
}
