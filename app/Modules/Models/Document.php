<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file', 'type',
    ];

    /**
     * Get the user of the document.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Scope a query to only include documents of the given user.
     *
     * @param  Builder  $query
     * @param  int      $user
     * @return Builder
     */
    public function scopeOfUser($query, $user)
    {
        return $query->whereHas('user', function ($query) use ($user) {
            $query->where('user_id', $user);
        });
    }
    
    /**
     * Scope a query to only include documents of the given type.
     *
     * @param  Builder  $query
     * @param  int      $type
     * @return Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
