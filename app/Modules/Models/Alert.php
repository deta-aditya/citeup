<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content',
    ];

    /**
     * Get the users that the alert is announced to.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('seen_at');
    }

    /**
     * Scope a query to only include announced alerts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeAnnounced($query)
    {
        return $query->has('users');
    }

    /**
     * Scope a query to only include unannounced alerts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeUnannounced($query)
    {
        return $query->doesntHave('users');
    }

    /**
     * Scope a query to only include alerts for the given users.
     *
     * @param  Builder  $query
     * @param  array    $users
     * @return Builder
     */
    public function scopeForUsers($query, array $users)
    {
        return $query->whereHas('users', function ($query) use ($users) {
            $query->whereIn('user_id', $users);
        });
    }

    /**
     * Scope a query to only include alerts seen by the given users.
     *
     * @param  Builder  $query
     * @param  array    $users
     * @return Builder
     */
    public function scopeSeenBy($query, array $users)
    {
        return $query->whereHas('users', function ($query) use ($users) {
            $query->where('user_id', $users)->where('seen_at', '<>', null);
        });
    }

    /**
     * Scope a query to only include alerts unseen by the given users.
     *
     * @param  Builder  $query
     * @param  array    $users
     * @return Builder
     */
    public function scopeUnseenBy($query, array $users)
    {
        return $query->whereHas('users', function ($query) use ($users) {
            $query->where('user_id', $users)->where('seen_at', null);
        });
    }
}
