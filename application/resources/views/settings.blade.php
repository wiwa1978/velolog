@extends('layouts.app')

@section('title', 'Settings - VeloLog')

@section('content')
            <div class="row">
                <div class="col-md-4">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
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

                        <input class="form-control" type="text" name="strava_id" value="{{ $settings->strava_id }}" />
                        
                        <input class="form-control" type="submit" />
                    </form>
                </div>
            </div>
@endsection
