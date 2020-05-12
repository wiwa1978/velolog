@extends('layouts.app')

@section('title', 'Strava Bikes - VeloLog')

@section('content')
            <div class="row">
                <div class="col-md-4">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    <h2>Sync Bikes</h2>
                    <form method="post" action="/bikes/store-strava-bikes">
                        @csrf
                        @foreach ($bikes as $bike)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $bike->id }}" name="bike_id[]">
                            <label class="form-check-label" for="defaultCheck1">
                            {{ $bike->name }}
                            </label>
                        </div>
                        @endforeach
                        <input class="form-control" type="submit" />
                    </form>
                </div>
            </div>
@endsection
