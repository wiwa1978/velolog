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
            </div>
@endsection
