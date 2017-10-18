<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{   
    /**
     * The lomba logika channel.
     */
    const CHANNEL_LOGIKA = 1;

    /**
     * The lomba desain channel.
     */
    const CHANNEL_DESAIN = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_id', 'message', 'channel', 
    ];

    /**
     * Get the entry who sends the chat.
     *
     * @return HasMany
     */
    public function entry()
    {
        return $this->belongsTo('App\Modules\Models\Entry');
    }    

    /**
     * Scope a query to only include chats in lomba logika channel.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeLogika($query)
    {
        return $query->ofChannel(Chat::CHANNEL_LOGIKA);
    }    

    /**
     * Scope a query to only include chats in lomba desain channel.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeDesain($query)
    {
        return $query->ofChannel(Chat::CHANNEL_DESAIN);
    }

    /**
     * Scope a query to only include chats with the given channel.
     *
     * @param  Builder  $query
     * @param  int      $channel
     * @return Builder
     */
    public function scopeOfChannel($query, $channel)
    {
        return $query->where('channel', $channel);
    }

    /**
     * Scope a query to only include chats from specific entry.
     *
     * @param  Builder  $query
     * @param  int      $entryId
     * @return Builder
     */
    public function scopeOfActivity($query, $entryId)
    {
        return $query->where('entry_id', $entryId);
    }
}
