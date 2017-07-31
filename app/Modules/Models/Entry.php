<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'activity_id', 'stage', 'status',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user who does the entry.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
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
     * Get the documents for the entry.
     *
     * @return HasMany
     */
    public function documents()
    {
        return $this->hasMany('App\Modules\Models\Document');
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
    
}
