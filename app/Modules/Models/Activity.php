<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Contracts\Models\Editable;
use App\Modules\Events\EditWasMade;

class Activity extends Model implements Editable
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['total_prizes'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'saved' => EditWasMade::class,
        'updated' => EditWasMade::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'short_description', 'icon', 
        'order', 'prize_first', 'prize_second', 'prize_third', 'guide',
    ];

    /**
     * Get the total prizes of the activity.
     *
     * @return int
     */
    public function getTotalPrizesAttribute()
    {
        return $this->isCompetition() ? 
            $this->prize_first + $this->prize_second + $this->prize_third : 0;            
    }

    /**
     * Get the entries of the activity.
     *
     * @return HasMany
     */
    public function entries()
    {
        return $this->hasMany('App\Modules\Models\Entry');
    }

    /**
     * Get the users that are entering the activity.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'entries')
                    ->withPivot('id', 'stage', 'status');
    }

    /**
     * Get the schedules of the activity.
     *
     * @return HasMany
     */
    public function schedules()
    {
        return $this->hasMany('App\Modules\Models\Schedule');
    }

    /**
     * Get the testimonials of the activity.
     *
     * @return HasManyThrough
     */
    public function testimonials()
    {
        return $this->hasManyThrough('App\Modules\Models\Testimonial', 
            'App\Modules\Models\Entry');
    }

    /**
     * Get all of the activity's tracked edits.
     *
     * @return MorphMany
     */
    public function edits()
    {
        return $this->morphMany('App\Modules\Models\Edit', 'editable');
    }

    /**
     * Check whether the activity is ordered.
     *
     * @return bool
     */
    public function isOrdered()
    {
        return $this->order >= 0;
    }

    /**
     * Check whether the activity is a competition.
     *
     * @return bool
     */
    public function isCompetition()
    {
        return (! (is_null($this->prize_first) 
                    || is_null($this->prize_second) 
                    || is_null($this->prize_third))
                ) || (
                    $this->prize_first === 0 
                    && $this->prize_second === 0 
                    && $this->prize_third === 0 
                );
    }
}
