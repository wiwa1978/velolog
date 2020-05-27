<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MaintenanceLog extends Model
{
    protected $fillable = ['type', 'bike_id', 'grease_monkey', 'distance_id'];

    static function getLogsAndRelated($userId)
    {
        return DB::table('maintenance_logs')
            ->join('bikes', 'maintenance_logs.bike_id', '=', 'bikes.id')
            ->join('distances', 'maintenance_logs.distance_id', '=', 'distances.id')
            ->select('maintenance_logs.*', 'bikes.name as bike_name', 'distances.metric', 'distances.imperial')
            ->where('bikes.user_id', $userId)
            ->orderBy('maintenance_logs.created_at', 'desc')
            ->get();

    }
}
