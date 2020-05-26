@extends('layouts.app')

@section('title', 'How to use - VeloLog')

@section('content')
            <div class="row">
                <div class="col-md-4">
                    <h2>How to use Velolog</h2>
                    <p>1. <a href="/">Create an account!</a></p>
                    <p>1a. To sync your bikes from strava check the 'Connect strava' box. You can do this later by navigating to settings and click sync strava if you missed this when creating you account. Your distance updates automatically.</p>
                    <p>1b. If you don't want use or don't have a strava account, once you have logged in navigate to 'Bikes' and create your gear there. Each time you log maintenance you'll be able to update the distance that the bike has travelled.</p>
                    <p>2. Once logged in you will be presented with the log page. You can choose work type, the component, who did the work and make notes about it. </p>
                    <p>3. You can see your log history on the log page too.</p>
                </div>
            </div>
@endsection
