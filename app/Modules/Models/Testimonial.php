<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_id', 'content', 'rating',
    ];

    /**
     * Get the entry of the testimonial.
     *
     * @return BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo('App\Modules\Models\Entry');
    }

    /**
     * Scope a query to only include testimonials of the given entry.
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
     * Scope a query to only include testimonials of the given rating.
     *
     * @param  Builder  $query
     * @param  int      $rating
     * @return Builder
     */
    public function scopeOfRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }
}
