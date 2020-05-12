@extends('layouts.app')

@section('title', 'Bikes - VeloLog')

@section('content')
            <div class="row">
                <div class="col-md-4">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    <h2>Add Bike</h2>
                    <form method="post" action="/bikes/store">
                        @csrf
                        <input class="form-control" type="text" placeholder="Name of the bike" name="name" required />

                        <input class="form-control" type="text" placeholder="Make" name="make" required />
                        
                        <input class="form-control" type="text" placeholder="Model" name="model" required />

                        <input class="form-control" type="text" placeholder="Serial number" name="serial" required />
                        <input class="form-control" type="submit" />
                    </form>
                </div>
                <div class="col-md-4">
                @foreach ($bikes as $bike)
                    <div class="card bg-light mb-3">
                        <div class="card-header">{{ ucfirst($bike->name) }} <small>({{ isset($distances[$bike->id][$units]) ? $distances[$bike->id][$units] : 0 }}{{ $units == 'metric' ? 'km' : 'mi' }})</small></div>
                        <div class="card-body pb-2">
                            <h5 class="card-title">{{ ucfirst($bike->make) }}</h5>
                            <p>{{ ucfirst($bike->model) }}</p>
                        </div>
                    </div>
                @endforeach
                </div>
                @if($strava_authorised)
                <form method="post" action="/bikes/sync-strava-bikes">
                    @csrf
                    <input class="form-control" type="submit" value="Sync Strava Bikes" />
                </form>
                @endif
            </div>
@endsection
