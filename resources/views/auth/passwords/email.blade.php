@extends('layouts.auth.app')

@section('content')
  <div class="panel-heading">Reset Password</div>
  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
      {{ csrf_field() }}
        @if ($errors->has('email'))
          <p class="text-danger">
              <strong>{{ $errors->first('email') }}</strong>
          </p>
        @endif
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-user"></i></div>
              <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
          </div>
        </div>

        <div class="row">
            <div class="col-xs-4 col-xs-offset-6">
                <div class="form-group">
                  <button type="submit" class="btn btn-success">
                      Send Password Reset Link
                  </button>
                </div>
            </div>
        </div>
  </form>
@endsection
