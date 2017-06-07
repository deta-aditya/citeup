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
     * Scope a query to only include users of a given role.
     *
     * @param  Builder $query
     * @param  int     $role
     * @return Builder
     */
    public function scopeOfRole($query, $role)
    {
        return $query->where('role_id', $role);
    }
    
}