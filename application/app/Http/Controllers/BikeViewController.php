<?php

namespace App\Http\Controllers;

use App\User;
use App\Bike;
use App\Distance;
use App\StravaModel;
use App\StravaSettings;
use CreateDistancesTable;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Passport\Client as OClient; 

class BikeViewController extends Controller
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
    public function index()
    {
        $bikes = Bike::where('user_id', Auth::user()->id)->get();
        $bikes_array = [];
        $distances_array = [];

        $strava_settings = new StravaSettings;
        $strava_authorised = $strava_settings->IsStravaAuthorised(Auth::user()->id);

        foreach ($bikes as $bike) {
            $bikes_array[] = $bike->id;
        }

        // todo get distances associated with bikes
        $distances = Distance::whereIn('bike_id', $bikes_array)
            ->select(DB::raw('max(metric) as metric, max(imperial) as imperial, bike_id'))
            ->groupBy('bike_id')
            ->get();

        foreach ($distances as $distance) {
            $distances_array[$distance->bike_id] = [
                'metric' => $distance->metric,
                'imperial' => $distance->imperial,
            ];
        }

        return view('bike', ['bikes' => $bikes, 'distances' => $distances_array, 'units' => Auth::user()->units, 'strava_authorised' => $strava_authorised]);
    }

    public function viewStravaGear()
    {
        $stravaModel = new StravaModel();
        $stravaSettings = StravaSettings::where('user_id', Auth::user()->id)->first();

        // this reall should be in a different function/model
        // comparing epoch time of token expiry vs now
        if ($stravaSettings->expires_at < time()) {
            $refreshedToken = $stravaModel->refreshToken($stravaSettings->refresh_token);

            $stravaSettings->access_token = $refreshedToken->access_token;
            $stravaSettings->refresh_token = $refreshedToken->refresh_token;
            $stravaSettings->expires_at = $refreshedToken->expires_at;

            $stravaSettings->save();
        }

        try {
            $athlete = $stravaModel->athlete($stravaSettings->access_token);

        } catch (Exception $e) {
            return redirect('bikes')->with('error', 'Trouble connecting to strava');
        }

        if (empty($athlete->bikes)) {
            return redirect('bikes')->with('error', 'No bikes found');
        }

        $bike_array = [];
        foreach ($athlete->bikes as $bike) {
            $bike_array[$bike->id] = $bike;
        }

        session(['strava_bikes' => $bike_array]);

        return view('stravabike', ['bikes' => $athlete->bikes]);
    }

    public function storeStravaGear(Request $request)
    {
        $requestObject = $request->all();
        // this is probably a really bad way to do this
        // would you throw this into a quick queue?
        $bike_session = session('strava_bikes');

        foreach ($requestObject['bike_id'] as $bike_id) {
            // TODO sync with strava gear to get each bike info
            $bikeObject['id'] = $bike_id;
            $bikeObject['name'] = $bike_session[$bike_id];
            $bikeObject['user_id'] = Auth::user()->id;

            $bike = Bike::save($bikeObject);
        }
    }

    public function store(Request $request)
    {
        // need to add backend validation
        $requestObject = $request->all();

        $requestObject['id'] = Str::uuid();
        $requestObject['user_id'] = Auth::user()->id;

        $bike = Bike::create($requestObject);

        return redirect('bikes')->withSuccess('Bike Saved!');
    }
}
