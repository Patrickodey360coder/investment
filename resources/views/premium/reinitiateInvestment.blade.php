@extends('layouts.user.app')
  @section('title')
    Reinitiate Investment
  @endsection
  @section('page-content')
                <div id="page-content">
       
            <div class="panel">
@if($canReinitiate)                    
                  <form id="demo-bvd-notempty" action="{{ route('premium.reinitiateInvestment.save') }}" method="post" class="form-horizontal">
                  
                    <div class="panel-body">
                      {{ csrf_field() }}
          
                    <fieldset>
                        @include('layouts.includes.errors')
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Investment Amount</label>
                      <div class="col-lg-5">
                        <input type="number" id="p2" class="form-control" min="200000" name="amount" placeholder="Investment Amount" required>
                      </div>
                    </div>
                         
                      <div class="form-group">
              <label class="col-lg-3 control-label">Investment Duration</label>
              <div class="col-lg-5">
                <select class="form-control" name="months" required>
                  <?php
                    for ($months=6; $months <= 24; $months++) { 
                      echo "<option value='".$months."'>".$months." months</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            </fieldset>
                     
                    </div>
                    <div class="panel-footer">
            <div class="row">
              <div class="col-sm-7 col-sm-offset-3">
                <button onclick="process()" name="update" class="btn btn-primary btn-labeled fa fa-check fa-lg" type="submit">Save</button>
              </div>
            </div>
          </div>
               </form>
@else
  <div>
    <h3 class="text-center" style="margin: 0 60px; padding: 60px 0">Sorry you have a running investment. Please contact the administrator to top up your investment</h3>
  </div>
@endif
        </div>
          
                </div>
  @endsection
  @section('scripts')
    <script type='text/javascript' src="{{ asset('js/jquery-2.2.1.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/bootstrap.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/nifty.min.js?v=1.1') }}"></script>
  @endsection