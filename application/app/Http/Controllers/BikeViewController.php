<?php

namespace App\Http\Controllers;

use App\User;
use App\Bike;
use App\Distance;
use App\StravaBikeModel;
use App\StravaModel;
use App\StravaSettings;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    // this function needs improving!
    public function getStravaGear()
    {
        $stravaBikeModel = new StravaBikeModel();
        $stravaBikeModel->fetchStravaGear();

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
