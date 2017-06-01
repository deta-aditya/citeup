<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'picture',
    ];

    /**
     * Get the answers that choose the choice.
     *
     * @return HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Modules\Models\Answer');
    }

    /**
     * Get the question that the choice belongs to.
     *
     * @return BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Modules\Models\Question');
    }
}
