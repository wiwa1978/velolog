<?php

namespace App\Http\Controllers;

use App\User;
use App\Bike;
use App\Distance;
use CreateDistancesTable;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client as OClient; 

class StravaSettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function completeRegistration()
    {
        echo env('CT_STRAVA_REDIRECT_URI', '');
        echo env('CT_STRAVA_SECRET_ID', '');
    }
}
