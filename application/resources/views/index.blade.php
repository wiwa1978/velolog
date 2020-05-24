@extends('layouts.app')

@section('title', 'Welcome - VeloLog')

@section('content')
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Welcome to VeloLog</h2>
                            <p>If you're fastidious about bike maintainance you'll need to store your schedule; be it repair, upgrades or simply cleaning. Create an account today to log your maintenance</p>
                        </div>

                        <div class="col-md-6">
                            <h2>Register</h2>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right pt-4">{{ __('Name') }}</label>

                                    <div class="col-md-8">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right pt-4">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-8">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right pt-4">{{ __('Password') }}</label>

                                    <div class="col-md-8">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required minlength="8" autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right pt-4">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-8">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right pt-4">{{ __('Preferred Units') }}</label>

                                    <div class="col-md-8">
                                        <select name="units" class="form-control" required>
                                            <option value="metric">Metric (kilometers)</option>
                                            <option value="imperial">Imperial (miles)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="connect-strava" class="col-md-4 col-form-label text-md-right pt-4 w-25">{{ __('Connect Strava?') }}</label>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-control form-check-input ml-0 mt-4" id="connect-strava" name="connectstrava" />
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <p class="text-right"><a href="/password/reset">Forgotten password?</a></p>
                        </div>
                    </div>
                </main>
@endsection