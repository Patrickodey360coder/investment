@extends('layouts.user.app')
  @section('title')
    Make Payment
  @endsection

  @section('page-content')
  	<div class="panel">
        <div class="panel-body">
          <div class="panel">
            <div class="panel-body">
              <h3 class="text-center">Please contact the admin for more details on how to make payments</h3>
            </div>
          </div>
        </div>
      </div>
  @endsection

  @section('scripts')
    <script type='text/javascript' src="{{ asset('/js/jquery-2.2.1.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('/js/bootstrap.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('/js/nifty.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('/plugins/fast-click/fastclick.min.js?v=1.1') }}"></script>
  @endsection