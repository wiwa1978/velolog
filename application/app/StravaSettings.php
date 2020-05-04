<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StravaSettings extends Model
{
    protected $fillable = ['user_id', 'strava_authorised'];
}
