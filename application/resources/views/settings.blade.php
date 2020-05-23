@extends('layouts.app')

@section('title', 'Settings - VeloLog')

@section('content')
            <div class="row">
                <div class="col-md-4">
                    <h2>Settings</h2>
                    <form method="post" action="/settings/store">
                        @csrf
                        <select name="units" class="form-control" required>
                            <option value="" disabled selected>Select units...</option>
                            @foreach ($units as $unit)
                            <option value="{{ $unit }}" {{ ( $unit == $settings->units) ? 'selected' : '' }}> 
                                {{ $unit }} 
                            </option>
                            @endforeach
                        </select>
                        
                        <input class="form-control" type="submit" />
                    </form>

                    @if(!$strava_authorised)
                    <form method="post" action="/settings/connect-strava">
                        @csrf
                        <input class="form-control" type="submit" value="Connect Strava" />
                    </form>
                    @endif
                    @if($strava_authorised)
                    <form method="post" action="/bikes/sync-strava-bikes">
                        @csrf
                        <input class="form-control" type="submit" value="Resync Strava Bikes" />
                    </form>
                    @endif
                </div>
            </div>
@endsection
