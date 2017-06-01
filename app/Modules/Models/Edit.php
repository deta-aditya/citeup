<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Edit extends Model
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
     * Get all of the owning editable models.
     *
     * @return MorphTo
     */
    public function editable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who is responsible for the edit.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
