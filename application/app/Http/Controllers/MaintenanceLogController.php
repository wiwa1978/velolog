<?php

namespace App\Http\Controllers;

use App\MaintenanceLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MaintenanceLogController extends Controller
{
    public function index()
    {
        return MaintenanceLog::all();
    }

    public function show(MaintenanceLog $maintenanceLog)
    {
        return $maintenanceLog;
    }

    public function store(Request $request)
    {
        $requestObject = $request->all();

        $maintenanceLog = MaintenanceLog::create($requestObject);

        return response()->json($maintenanceLog, 201);
    }

    public function update(Request $request, MaintenanceLog $maintenanceLog)
    {
        $maintenanceLog->update($request->all());

        return response()->json($maintenanceLog, 200);
    }

    public function delete(MaintenanceLog $maintenanceLog)
    {
        $maintenanceLog->delete();

        return response()->json(null, 204);
    }
}
