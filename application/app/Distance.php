<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    protected $fillable = ['bike_id', 'imperial', 'metric'];
}
