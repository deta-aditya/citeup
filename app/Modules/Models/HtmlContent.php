<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Contracts\Models\Editable;
use App\Modules\Events\EditWasMade;

class HtmlContent extends Model implements Editable
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
        'name', 'content',
    ];

    /**
     * Get all of the gallery's tracked edits.
     *
     * @return MorphMany
     */
    public function edits()
    {
        return $this->morphMany('App\Modules\Models\Edit', 'editable');
    }
}
