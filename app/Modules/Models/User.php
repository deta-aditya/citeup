<?php

namespace App\Modules\Models;

trait User
{
    /**
     * Get the user's role.
     *
     * @return string
     */
    public function getRolenameAttribute()
    {
        return $this->role->name;
    }

    /**
     * Get the user's flag for Entrant.
     *
     * @return bool
     */
    public function getEntrantAttribute()
    {
        return $this->isEntrant();
    }

    /**
     * Get the user's flag for Committee.
     *
     * @return bool
     */
    public function getCommitteeAttribute()
    {
        return $this->isCommittee();
    }

    /**
     * Get the user's flag for Admin.
     *
     * @return bool
     */
    public function getAdminAttribute()
    {
        return $this->isAdmin();
    }

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
     * Get the entry of the user.
     *
     * @return BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo('App\Modules\Models\Entry');
    }

    /**
     * Get the alerts that are announced for the user.
     *
     * @return BelongsToMany
     */
    public function alerts()
    {
        return $this->belongsToMany('App\Modules\Models\Alert')
            ->withPivot('seen_at', 'announced_at');
    }

    /**
     * Get the documents for the user.
     *
     * @return HasMany
     */
    public function documents()
    {
        return $this->hasMany('App\Modules\Models\Document');
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
        return $this->rolename === 'Administrator';
    }

    /**
     * Check whether this user is a committee.
     *
     * @return bool
     */
    public function isCommittee()
    {
        return $this->rolename === 'Committee';
    }

    /**
     * Check whether this user is an entrant.
     *
     * @return bool
     */
    public function isEntrant()
    {
        return $this->rolename === 'Entrant';
    }

    /**
     * Check whether this user can access the given key.
     *
     * @param  string|int  $key
     * @return bool
     */
    public function hasKey($key)
    {
        $query = $this->keys();

        is_int($key) ? $query->where('id', $key) : $query->where('slug', $key);

        return $query->count() > 0;
    }

    /**
     * Determine whether this user can perform authentication.
     *
     * @return bool
     */
    public function canAuth()
    {
        return ! ($this->crew || is_null($this->password));
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
        return $query->where('name', 'like', '%' . $name . '%');
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