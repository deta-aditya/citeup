<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Contracts\Models\Editable;
use App\Modules\Events\EditWasMade;

class Activity extends Model implements Editable
{
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
    ];

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
    
}
