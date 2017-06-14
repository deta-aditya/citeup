<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the users who have the key.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Scope a query to only include keys with the given slugs.
     *
     * @param  Builder  $query
     * @param  array    $slugs
     * @return Builder
     */
    public function scopeOfSlugs($query, $slugs)
    {
        return $query->whereIn('slug', $slugs);
    }

    /**
     * Scope a query to only include keys who are held by the given users.
     *
     * @param  Builder  $query
     * @param  array    $users
     * @return Builder
     */
    public function scopeOwnedByUsers($query, $users)
    {
        return $query->whereHas('users', function ($query) use ($users) {
            $query->whereIn('id', $users);
        });
    }

}
