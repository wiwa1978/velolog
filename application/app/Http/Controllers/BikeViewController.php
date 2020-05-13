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
use stdClass;

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

        foreach ($athlete->bikes as $bike) {
            try {
                $bike = $stravaModel->gear($stravaSettings->access_token, $bike->id);
            } catch (Exception $e) {
                return redirect('bikes')->with('error', 'Issue syncing bikes. Please try again');
            }

            // this is bullshit but i can't think how to make it better
            if ($bikeObject = Bike::where('id', $bike->id)->first()) {
                $bikeObject['id'] = $bike->id;
                $bikeObject['name'] = $bike->name;
                $bikeObject['make'] = $bike->brand_name;
                $bikeObject['model'] = $bike->model_name;
                $bikeObject['user_id'] = Auth::user()->id;
                $bikeObject->save();
            } else {
                $bikeObject['id'] = $bike->id;
                $bikeObject['name'] = $bike->name;
                $bikeObject['make'] = $bike->brand_name;
                $bikeObject['model'] = $bike->model_name;
                $bikeObject['user_id'] = Auth::user()->id;
                Bike::create($bikeObject);
            }

            // strava delivers in metres
            $distances = $bike->distance / 1000;

            $distanceObject['bike_id'] = $bike->id; 
            $distanceObject['metric'] = round($distances);
            $distanceObject['imperial'] = round($distances / 1.6);
            $distance = Distance::create($distanceObject);
        }

        return redirect('bikes')->withSuccess('Bikes synced from Strava!');
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
