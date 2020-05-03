<?php

namespace App\Http\Controllers;

use App\User;
use App\UserSettings;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Laravel\Passport\Client as OClient; 

class UserSettingsController extends Controller
{
    public $successStatus = 200;

    public function index() {

        $units = ['metric', 'imperial'];

        $settings = UserSettings::where('user_id', Auth::user()->id)->get()->first();

        return view('settings', ['settings' => $settings, 'units' => $units]);
    }

    public function store(Request $request)
    {
        // need to add backend validation
        $requestObject = $request->all();

        $settings = UserSettings::where('user_id', Auth::user()->id)->get()->first();

        $settings->units = $requestObject['units'];
        $settings->strava_id = isset($requestObject['strava_id']) ? $requestObject['strava_id'] : '';

        $settings->save();

        return redirect('settings')->withSuccess('Settings updated!');;
    }
}
