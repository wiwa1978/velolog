<?php

namespace App;

use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bike extends Model
{
    protected $fillable = ['name', 'make', 'model', 'user_id', 'serial', 'strava_bike_id'];

}
