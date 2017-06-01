<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //
    ];

    /**
     * Get the attempt associated with the answer.
     *
     * @return BelongsTo
     */
    public function attempt()
    {
        return $this->belongsTo('App\Modules\Models\Attempt');
    }

    /**
     * Get the choice chosen in the answer.
     *
     * @return BelongsTo
     */
    public function choice()
    {
        return $this->belongsTo('App\Modules\Models\Choice');
    }

}
