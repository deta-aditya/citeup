<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_id', 'picture', 'description',
    ];

    /**
     * Get the entry of the submission.
     *
     * @return BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo('App\Modules\Models\Entry');
    }

    /**
     * Scope a query to only include submissions of the given entry.
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
}
