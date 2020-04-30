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
                            <form method="post" action="/api/register">
                                <input class="form-control" type="text" placeholder="Name" name="name" required />
                                <input class="form-control" type="email" placeholder="Email" name="email"  required />
                                <input class="form-control" type="password" placeholder="Password" name="password"  required />
                                <input class="form-control" type="password" placeholder="Confirm Password" name="c_password" required />
                                <select name="units" class="form-control" required>
                                    <option value="" disabled selected>Preferred Units</option>
                                    <option value="metric">Metric (kilometers)</option>
                                    <option value="imperial">Imperial (miles)</option>
                                </select>
                                <input class="form-control" type="submit" />
                            </form>
                        </div>
                    </div>
                </main>
@endsection