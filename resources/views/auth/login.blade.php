@extends('layouts.auth.app')

@section('content')
   <p class="pad-btm">Sign In to your account</p>
  <form class="form-horizontal" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
      @if ($errors->has('email'))
        <p class="text-danger">
          <strong>{{ $errors->first('email') }}</strong>
        </p>
      @endif
      <div class="form-group">
          <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-user"></i></div>
              <input id="email" type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
          </div>
      </div>
      <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
            <input id="key" name="password" type="password" class="form-control" placeholder="Password" required>
            @if ($errors->has('password'))
              <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
            @endif
        </div>
      </div>
      <div class="form-group">
        <div class="input-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 text-left checkbox">
          <a class="btn btn-link" href="{{ route('password.request') }}" style="color: blue;">
            Forgot Your Password?
          </a>
        </div>
        <div class="col-xs-4">
            <div class="form-group text-right">
            <button id="login_button" class="btn btn-success text-uppercase" type="submit">Sign In</button>
            </div>
        </div>
    </div>
  </form>
@endsection