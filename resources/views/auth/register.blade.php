@extends('layouts.auth.app')

@section('content')
    <p class="pad-btm">Register</p>
    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            @if ($errors->has('name'))
                <p class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </p>
            @endif
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-user"></i></div>
              <input id="name" type="text" name="name" maxlength="255" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            @if ($errors->has('email'))
                <p class="text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </p>
            @endif
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-user"></i></div>
              <input id="email" type="text" name="email" maxlength="255" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
            @if ($errors->has('country'))
                <p class="text-danger">
                    <strong>{{ $errors->first('country') }}</strong>
                </p>
            @endif
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-location-arrow"></i></div>
              <select id="country" type="text" name="country" class="form-control" required>
                <option value="">Please select a country</option>
                @foreach($countries as $country)
                    @if (old('country') == $country)
                        <option value="{{ $country }}" selected>{{ $country }}</option>
                    @else
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endif
                @endforeach
              </select>
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            @if ($errors->has('password'))
                <p class="text-danger">
                    <strong>{{ $errors->first('password') }}</strong>
                </p>
            @endif
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-lock"></i></div>
              <input id="password" type="password" name="password" minlength="8" class="form-control" placeholder="Password" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-lock"></i></div>
              <input id="password-confirm" type="password" minlength="8" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8 text-left checkbox">
              <a class="btn btn-link" href="{{ route('login') }}" style="color: blue;">
                Sign In
              </a>
            </div>
            <div class="col-xs-4">
                <div class="form-group text-right">
                    <button id="login_button" class="btn btn-success text-uppercase" type="submit">Register</button>
                </div>
            </div>
        </div>
    </form>
@endsection
