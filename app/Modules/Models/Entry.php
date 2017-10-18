<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_id', 'name', 'agency', 'city', 
    ];

    /**
     * Get the users who entry.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the activity associated with the entry.
     *
     * @return BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo('App\Modules\Models\Activity');
    }

    /**
     * Get the test attempts during the entry.
     *
     * @return HasMany
     */
    public function attempts()
    {
        return $this->hasMany('App\Modules\Models\Attempt');
    }

    /**
     * Get the submissions during the entry.
     *
     * @return HasMany
     */
    public function submissions()
    {
        return $this->hasMany('App\Modules\Models\Submission');
    }

    /**
     * Get the testimonials of the entry.
     *
     * @return HasMany
     */
    public function testimonials()
    {
        return $this->hasMany('App\Modules\Models\Testimonial');
    }

    /**
     * Get the chats related to the entry.
     *
     * @return HasMany
     */
    public function chats()
    {
        return $this->hasMany('App\Modules\Models\Chat');
    }    

    /**
     * Scope a query to only include entries with the given stage.
     *
     * @param  Builder  $query
     * @param  int      $stage
     * @return Builder
     */
    public function scopeOfStage($query, $stage)
    {
        return $query->where('stage', $stage);
    }  

    /**
     * Scope a query to only include entries who enter the given activity.
     *
     * @param  Builder  $query
     * @param  int      $activity
     * @return Builder
     */
    public function scopeOfActivity($query, $activity)
    {
        return $query->whereHas('activity', function ($query) use ($activity) {
            $query->where('id', $activity);
        });
    }
}
