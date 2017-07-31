<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attempt_id', 'choice_id',
    ];

    /**
     * Get the attempt associated with the answer.
     *
     * @return BelongsTo
     */
    public function attempt()
    {
        return $this->belongsTo('App\Modules\Models\Attempt');
    }

    /**
     * Get the choice chosen in the answer.
     *
     * @return BelongsTo
     */
    public function choice()
    {
        return $this->belongsTo('App\Modules\Models\Choice');
    }

    /**
     * Scope a query to only include answers of the given question.
     *
     * @param  Builder  $query
     * @param  int      $question
     * @return Builder
     */
    public function scopeOfQuestion($query, $question)
    {
        return $query->whereHas('choice', function ($query) use ($question) {
            $query->where('question_id', $question);
        });
    }

    /**
     * Scope a query to only include answers of the given choice.
     *
     * @param  Builder  $query
     * @param  int      $choice
     * @return Builder
     */
    public function scopeOfChoice($query, $choice)
    {
        return $query->where('choice_id', $choice);
    }

    /**
     * Scope a query to only include answers of the given attempt.
     *
     * @param  Builder  $query
     * @param  int      $attempt
     * @return Builder
     */
    public function scopeOfAttempt($query, $attempt)
    {
        return $query->where('attempt_id', $attempt);
    }
}
