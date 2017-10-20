<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_id', 'message', 'committee', 
    ];

    /**
     * Get the entry who is related the chat.
     *
     * @return BelongsTO
     */
    public function entry()
    {
        return $this->belongsTo('App\Modules\Models\Entry');
    }

    /**
     * Scope a query to only include chats from entrant.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFromEntrant($query)
    {
        return $query->where('committee', 0);
    }

    /**
     * Scope a query to only include chats from committee.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFromCommittee($query)
    {
        return $query->where('committee', 1);
    }

    /**
     * Scope a query to only include chats of specific entry.
     *
     * @param  Builder  $query
     * @param  int      $entryId
     * @return Builder
     */
    public function scopeOfEntry($query, $entryId)
    {
        return $query->where('entry_id', $entryId);
    }

    /**
     * Scope a query to only include unread chats.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeUnread($query)
    {
        return $query->where('read_at', null);
    }
}
