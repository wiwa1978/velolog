<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    protected $fillable = ['type', 'component', 'note', 'bike_id', 'grease_monkey', 'distance_id'];
}
