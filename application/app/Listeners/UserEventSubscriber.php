<?php

namespace App\Listeners;

use App\StravaBikeModel;
use App\StravaSettings;
use Illuminate\Support\Facades\Auth;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function handleUserLogin($event) {

        // check if strava settings set yet
        $stravaSettings = StravaSettings::where('user_id', Auth::user()->id)->first();

        if  (!empty($stravaSettings)) {
            //update distance
            $stravaBikeModel = new StravaBikeModel();
            $stravaBikeModel->updateDistances();
        }

    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event) {}

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@handleUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@handleUserLogout'
        );
    }
}