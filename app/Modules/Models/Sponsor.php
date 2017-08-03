<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Contracts\Models\Editable;
use App\Modules\Events\EditWasMade;

class Sponsor extends Model implements Editable
{
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'saved' => EditWasMade::class,
        'updated' => EditWasMade::class,
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'picture', 'type', 'url',
    ];

    /**
     * Get all of the sponsor's tracked edits.
     *
     * @return MorphMany
     */
    public function edits()
    {
        return $this->morphMany('App\Modules\Models\Edit', 'editable');
    }

    /**
     * Scope a query to only include sponsors of the given type.
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
