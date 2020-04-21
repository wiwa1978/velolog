<?php

namespace App\Http\Controllers;

use App\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function index()
    {
        return Bike::all();
    }

    public function show(Bike $bike)
    {
        return $bike;
    }

    public function store(Request $request)
    {
        $bike = Bike::create($request->all());

        return response()->json($bike, 201);
    }

    public function update(Request $request, Bike $bike)
    {
        $bike->update($request->all());

        return response()->json($bike, 200);
    }

    public function delete(Bike $bike)
    {
        $bike->delete();

        return response()->json(null, 204);
    }
}
