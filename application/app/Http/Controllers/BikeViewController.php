<?php

namespace App\Http\Controllers;

use App\User;
use App\Bike;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
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

        return view('bike', ['bikes' => $bikes]);
    }

    public function store(Request $request)
    {
        // need to add backend validation
        $requestObject = $request->all();

        $requestObject['user_id'] = Auth::user()->id;

        $bike = Bike::create($requestObject);

        return redirect('bikes')->withSuccess('Bike Saved!');;
    }
}
