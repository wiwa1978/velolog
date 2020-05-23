@extends('layouts.app')

@section('title', 'Log - VeloLog')

@section('content')
            <div class="row">
                <div class="col-md-4">
                    <h2>Log work...</h2>
                    <form method="post" action="/logs/store">
                        @csrf
                        <select name="bike_id" id="bike-id" class="form-control" required>
                            <option value="" disabled selected>Select bike...</option>
                            @foreach ($bikes as $bike)
                            <option value="{{ $bike->id }}">{{ $bike->name }}</option>
                            @endforeach
                        </select>
                        <select name="type" class="form-control" required>
                            <option value="" disabled selected>Job type</option>
                            <option value="upgrade">Upgrade</option>
                            <option value="clean">Clean</option>
                            <option value="repair">Repair</option>
                            <option value="rebuild">Rebuild</option>
                        </select>
                        <select name="component" class="form-control">
                            <option value="" disabled selected>Component</option>
                            <option value="Bar ends">Bar ends</option>
                            <option value="Bearing">Bearing</option>
                            <option value="Belt-drive">Belt-drive</option>
                            <option value="Bottle cage">Bottle cage</option>
                            <option value="Bottom bracket">Bottom bracket</option>
                            <option value="Brake">Brake</option>
                            <option value="Brake lever">Brake lever</option>
                            <option value="Cassette">Cassette</option>
                            <option value="Chain">Chain</option>
                            <option value="Chainring">Chainring</option>
                            <option value="Chain tensioner">Chain tensioner</option>
                            <option value="Crankset">Crankset</option>
                            <option value="Derailleur hanger">Derailleur hanger</option>
                            <option value="Derailleur (front)">Derailleur (front)</option>
                            <option value="Derailleur (rear)">Derailleur (rear)</option>
                            <option value="Fork">Fork</option>
                            <option value="Gears">Gears</option>
                            <option value="Handlebar">Handlebar</option>
                            <option value="Handlebar tape">Handlebar tape</option>
                            <option value="Headset">Headset</option>
                            <option value="Inner tube">Inner tube</option>
                            <option value="Jockey wheel">Jockey wheel</option>
                            <option value="Pedal">Pedal</option>
                            <option value="Seat">Seat</option>
                            <option value="Seatpost">Seatpost</option>
                            <option value="Shifter">Shifter</option>
                            <option value="Stem">Stem</option>
                            <option value="Tyre">Tyre</option>
                            <option value="Wheel">Wheel</option>
                        </select>
                        <input class="form-control" type="distance" placeholder="How far has the bike travelled" name="distance" id="distance" @if (!empty($distances)) {{ "readonly='readonly'" }} @endif required />
                        <textarea placeholder="Description of work carried out..." name="note" class="form-control"></textarea>
                        <select name="grease_monkey" class="form-control" required>
                            <option value="" disabled selected>Who did the work?</option>
                            <option value="self">Self</option>
                            <option value="friend">Friend</option>
                            <option value="professional">Professional</option>
                        </select>
                        <input class="form-control" type="submit" />
                    </form>
                </div>
                <div class="col-md-4">
                @foreach ($logs as $log)
                    <div class="card bg-light mb-3">
                        <div class="card-header">{{ ucfirst($log->bike_name) }}</div>
                        <div class="card-body pb-2">
                            <h5 class="card-title">{{ ucfirst($log->type) }} ({{ lcfirst($log->component) }}) - {{ $log->$units }}{{ $units == 'metric' ? 'km' : 'mi' }}</h5>
                            <p>{{ mb_strimwidth($log->note, 0, 30, "...") }}</p>
                            <p class="text-right mb-0"><small>{{ $log->created_at }}</small></p>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

            <script>
                $( document ).ready( function() {
                    var miles = {
                    @foreach ($distances as $distance)
                        {{ $distance->bike_id }} : "{{ $distance->$units }}",
                    @endforeach
                    };

                    $('#bike-id').on('change', function() {
                        $('#distance').val(miles[this.value]);
                    });
                });
            </script>
@endsection
