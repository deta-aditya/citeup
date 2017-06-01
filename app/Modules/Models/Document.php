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
        'picture', 'type',
    ];

    /**
     * Get the entry of the document.
     *
     * @return BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo('App\Modules\Models\Entry');
    }
    
}
