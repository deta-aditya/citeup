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
        'entry_id', 'file', 'type',
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
    
    /**
     * Scope a query to only include documents of the given entry.
     *
     * @param  Builder  $query
     * @param  int      $entry
     * @return Builder
     */
    public function scopeOfEntry($query, $entry)
    {
        return $query->whereHas('entry', function ($query) use ($entry) {
            $query->where('entry_id', $entry);
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
