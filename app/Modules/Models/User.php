<?php

namespace App\Modules\Models;

trait User
{
    /**
     * Get the role of the user.
     *
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Modules\Models\Role');
    }

    /**
     * Get the keys that belongs to the user.
     *
     * @return BelongsToMany
     */
    public function keys()
    {
        return $this->belongsToMany('App\Modules\Models\Key');
    }

    /**
     * Get the profile model associated with the user.
     *
     * @return HasOne
     */
    public function profile()
    {
        return $this->hasOne('App\Modules\Models\Profile');
    }

    /**
     * Get the entry model associated with the user.
     *
     * @return HasOne
     */
    public function entry()
    {
        return $this->hasOne('App\Modules\Models\Entry');
    }

    /**
     * Get the activity that the user is entering.
     *
     * @return BelongsToMany
     */
    public function activity()
    {
        return $this->belongsToMany('App\Modules\Models\Activity', 'entries')
                    ->withPivot('id', 'stage', 'status');
    }

    /**
     * Get the documents of the user.
     *
     * @return HasManyThrough
     */
    public function documents()
    {
        return $this->hasManyThrough('App\Modules\Models\Document', 
            'App\Modules\Models\Entry');
    }

    /**
     * Get the test attempts of the user.
     *
     * @return HasManyThrough
     */
    public function attempts()
    {
        return $this->hasManyThrough('App\Modules\Models\Attempt', 
            'App\Modules\Models\Entry');
    }

    /**
     * Get the submissions by the user.
     *
     * @return HasManyThrough
     */
    public function submissions()
    {
        return $this->hasManyThrough('App\Modules\Models\Submission', 
            'App\Modules\Models\Entry');
    }

    /**
     * Get the testimonials by the user.
     *
     * @return HasManyThrough
     */
    public function testimonials()
    {
        return $this->hasManyThrough('App\Modules\Models\Testimonial', 
            'App\Modules\Models\Entry');
    }

    /**
     * Get the alerts that are announced for the user.
     *
     * @return BelongsToMany
     */
    public function alerts()
    {
        return $this->belongsToMany('App\Modules\Models\Alert')
            ->withPivot('seen_at');
    }

    /**
     * Get the edits done by the user.
     *
     * @return HasMany
     */
    public function edits()
    {
        return $this->hasMany('App\Modules\Models\Edit');
    }

    /**
     * Check whether this user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role->name === 'Administrator';
    }

    /**
     * Check whether this user is a committee.
     *
     * @return bool
     */
    public function isCommittee()
    {
        return $this->role->name === 'Committee';
    }

    /**
     * Check whether this user is an entrant.
     *
     * @return bool
     */
    public function isEntrant()
    {
        return $this->role->name === 'Entrant';
    }

    /**
     * Check whether this user can access the given key.
     *
     * @param  string|int  $key
     * @return bool
     */
    public function hasKey($key)
    {
        return (bool) $this->keys()->where('id', $key)->orWhere('slug', $key)->count();
    }

    /**
     * Scope a query to only include users of the given role.
     *
     * @param  Builder  $query
     * @param  int      $role
     * @return Builder
     */
    public function scopeOfRole($query, $role)
    {
        return $query->where('role_id', $role);
    }

    /**
     * Scope a query to only include users with the given name.
     *
     * @param  Builder  $query
     * @param  string   $name
     * @return Builder
     */
    public function scopeOfName($query, $name)
    {
        return $query->whereHas('profile', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
    }

    /**
     * Scope a query to only include users who enter the given activity.
     *
     * @param  Builder  $query
     * @param  int      $activity
     * @return Builder
     */
    public function scopeOfActivity($query, $activity)
    {
        return $query->whereHas('entry', function ($query) use ($activity) {
            $query->where('activity_id', $activity);
        });
    }

    /**
     * Scope a query to only include users who enter the given activities.
     *
     * @param  Builder  $query
     * @param  array    $activities
     * @return Builder
     */
    public function scopeOfActivities($query, $activities)
    {
        return $query->whereHas('activity', function ($query) use ($activities) {
            $query->whereIn('id', $activities);
        });
    }

    /**
     * Scope a query to only include users of the given stage.
     *
     * @param  Builder  $query
     * @param  int      $stage
     * @return Builder
     */
    public function scopeOfStage($query, $stage)
    {
        return $query->whereHas('entry', function ($query) use ($stage) {
            $query->where('stage', $stage);
        });
    }

    /**
     * Scope a query to only include users who can access the given keys.
     *
     * @param  Builder  $query
     * @param  array    $keys
     * @param  bool     $slug
     * @return Builder
     */
    public function scopeHasKeys($query, $keys, $slug = false)
    {
        return $query->whereHas('keys', function ($query) use ($keys, $slug) {
            $slug ? $query->whereIn('slug', $keys) : $query->whereIn('id', $keys);
        });
    }

    /**
     * Scope a query to only include users who were announced the given alert.
     *
     * @param  Builder  $query
     * @param  int      $alert
     * @return Builder
     */
    public function scopeOfAlert($query, $alert)
    {
        return $query->whereHas('alerts', function ($query) use ($alert) {
            $query->where('alert_id', $alert);
        });
    }
}