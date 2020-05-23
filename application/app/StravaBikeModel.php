<?php

namespace App;

use Exception;
use GuzzleHttp\Client;
use App\Bike;
use App\StravaModel;
use App\StravaSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StravaBikeModel extends Model
{
    private $stravaModel;
    private $stravaSettings;

    public function __construct()
    {
        $this->stravaModel = new StravaModel();
        $this->stravaSettings = StravaSettings::where('user_id', Auth::user()->id)->first();
    }

    // this function is a load of shit and needs refactoring
    // need to build up something so that we can fetch new miles on log in
    public function fetchStravaGear()
    {
        $athlete = $this->getAthlete();

        if (empty($athlete->bikes)) {
            return redirect('bikes')->with('error', 'No bikes found');
        }

        $deletedRows = Bike::where('user_id', Auth::user()->id)->delete();

        foreach ($athlete->bikes as $bike) {
            try {
                $bike = $this->stravaModel->gear($this->stravaSettings->access_token, $bike->id);
            } catch (Exception $e) {
                return redirect('bikes')->with('error', 'Issue syncing bikes. Please try again');
            }

            $bikeObject['id'] = $bike->id;
            $bikeObject['name'] = $bike->name;
            $bikeObject['make'] = $bike->brand_name;
            $bikeObject['model'] = $bike->model_name;
            $bikeObject['user_id'] = Auth::user()->id;
            Bike::create($bikeObject);

            // strava delivers in meters
            $distances = $bike->distance / 1000;

            $distanceObject['bike_id'] = $bike->id; 
            $distanceObject['metric'] = round($distances);
            $distanceObject['imperial'] = round($distances / 1.609344);
            $distance = Distance::create($distanceObject);
        }
    }

    public function updateDistances()
    {
        $athlete = $this->getAthlete();

        if (empty($athlete->bikes)) {
            return redirect('bikes')->with('error', "Error updating bikes' distances");
        }

        foreach ($athlete->bikes as $bike) {
            // strava delivers in meters
            $distances = $bike->distance / 1000;

            $distanceObject['bike_id'] = $bike->id; 
            $distanceObject['metric'] = round($distances);
            $distanceObject['imperial'] = round($distances / 1.609344);
            $distance = Distance::create($distanceObject);
        }
    }

    private function getAthlete()
    {
        // this really should be in a different function/model
        // comparing epoch time of token expiry vs now
        if (empty($this->stravaSettings->expires_at) || $this->stravaSettings->expires_at < time()) {
            $refreshedToken = $this->stravaModel->refreshToken($this->stravaSettings->refresh_token);

            $this->stravaSettings->access_token = $refreshedToken->access_token;
            $this->stravaSettings->refresh_token = $refreshedToken->refresh_token;
            $this->stravaSettings->expires_at = $refreshedToken->expires_at;

            $this->stravaSettings->save();
        }

        try {
            $athlete = $this->stravaModel->athlete($this->stravaSettings->access_token);

        } catch (Exception $e) {
            return redirect('bikes')->with('error', 'Trouble connecting to strava');
        }

        return $athlete;
    }
    
}
