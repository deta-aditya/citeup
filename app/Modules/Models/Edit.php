<?php

namespace App\Modules\Models;

use App\Modules\Models\Activity;
use App\Modules\Models\Schedule;
use App\Modules\Models\News;
use App\Modules\Models\Gallery;
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
    
    /**
     * Scope a query to only include edits of the given activity ID.
     *
     * @param  Builder  $query
     * @param  int      $activity
     * @return Builder
     */
    public function scopeOfActivity($query, $activity)
    {
        return $query->where([
            ['editable_type', '=', Activity::class],
            ['editable_id', '=', $activity],
        ]);
    }
    
    /**
     * Scope a query to only include edits of the given schedule ID.
     *
     * @param  Builder  $query
     * @param  int      $schedule
     * @return Builder
     */
    public function scopeOfSchedule($query, $schedule)
    {
        return $query->where([
            ['editable_type', '=', Schedule::class],
            ['editable_id', '=', $schedule],
        ]);
    }
    
    /**
     * Scope a query to only include edits of the given news ID.
     *
     * @param  Builder  $query
     * @param  int      $news
     * @return Builder
     */
    public function scopeOfNews($query, $news)
    {
        return $query->where([
            ['editable_type', '=', News::class],
            ['editable_id', '=', $news],
        ]);
    }
    
    /**
     * Scope a query to only include edits of the given gallery ID.
     *
     * @param  Builder  $query
     * @param  int      $gallery
     * @return Builder
     */
    public function scopeOfGallery($query, $gallery)
    {
        return $query->where([
            ['editable_type', '=', Gallery::class],
            ['editable_id', '=', $gallery],
        ]);
    }
    
    /**
     * Scope a query to only include edits of the given sponsor ID.
     *
     * @param  Builder  $query
     * @param  int      $sponsor
     * @return Builder
     */
    public function scopeOfSponsor($query, $sponsor)
    {
        return $query->where([
            ['editable_type', '=', Sponsor::class],
            ['editable_id', '=', $sponsor],
        ]);
    }
    
    /**
     * Scope a query to only include edits by the given user ID.
     *
     * @param  Builder  $query
     * @param  int      $user
     * @return Builder
     */
    public function scopeOfUser($query, $user)
    {
        return $query->where('user_id', $user);
    }
}
