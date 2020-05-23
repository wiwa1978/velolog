<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StravaSettings extends Model
{
    protected $fillable = ['user_id', 'strava_authorised', 'strava_id', 'return_code', 'access_token', 'refresh_token', 'expires_at'];

    public function IsStravaAuthorised($id)
    {
        $strava_settings = self::where('user_id', $id)->get()->first();

        return isset($strava_settings->strava_authorised) ? $strava_settings->strava_authorised : false;
    }
}
