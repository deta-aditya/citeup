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
}
