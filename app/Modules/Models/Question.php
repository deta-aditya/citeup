<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
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
     * Get the choices of the question.
     *
     * @return HasMany
     */
    public function choices()
    {
        return $this->hasMany('App\Modules\Models\Choice');
    }

    /**
     * Get the answers of the question.
     *
     * @return HasManyThrough
     */
    public function answers()
    {
        return $this->hasManyThrough('App\Modules\Models\Answer', 
            'App\Modules\Models\Choice');
    }
}
