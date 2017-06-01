<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the users under the role.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

}
