<?php

namespace App\Modules\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'started_at', 'finished_at',
    ];

    /**
     * Check whether the stage is currently in the given argument ID.
     */
    public function isOn($id) {
        return $this->id === $id;
    }

    /**
     * Scope a query to only include the current scope.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCurrent($query) {

        $now = Carbon::now()->format('Y-m-d H:i:s');

        return $query->where([
            ['started_at', '<=', $now],
            ['finished_at', '>=', $now],
        ]);

    }

}
