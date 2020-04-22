<?php

namespace App;

use App\User;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    protected $fillable = ['name', 'make', 'model', 'user_id', 'serial'];

}
