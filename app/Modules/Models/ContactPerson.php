<?php

namespace App\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'line',
    ];
}
