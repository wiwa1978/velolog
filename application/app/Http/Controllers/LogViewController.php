<?php

namespace App\Http\Controllers;

use App\User;
use App\Bike;
use App\Distance;
use App\MaintenanceLog;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Laravel\Passport\Client as OClient; 

class LogViewController extends Controller
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
        $user_id = Auth::user()->id;

        $bikes = Bike::where('user_id', $user_id)->get();

        $logs = MaintenanceLog::getLogsAndRelated($user_id);

        return view('log', ['bikes' => $bikes, 'logs' => $logs, 'units' => Auth::user()->units]);
    }

    public function store(Request $request)
    {
        $requestObject = $request->all();
        $distanceObject['bike_id'] = $requestObject['bike_id']; 
        $distanceObject['metric'] = $requestObject['distance'];
        $distanceObject['imperial'] = round($requestObject['distance'] / 1.609344);
        
        unset($requestObject['distance']);

        $distance = Distance::create($distanceObject);

        $requestObject['distance_id'] = $distance->id;

        $maintenanceLog = MaintenanceLog::create($requestObject);

        return redirect('home')->withSuccess('Log Saved!');;
    }
}
