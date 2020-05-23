<?php

namespace App\Http\Controllers;

use App\User;
use App\UserSettings;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Laravel\Passport\Client as OClient; 

class UserController extends Controller
{
    public $successStatus = 200;
}
