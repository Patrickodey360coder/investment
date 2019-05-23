@extends('layouts.user.app')
  @section('title')
    My Bank Account
  @endsection
  @section('page-content')
                <div id="page-content">
       
            <div class="panel">
                    
                  <form id="demo-bvd-notempty" action="{{ route('user.bank.update') }}" method="post" class="form-horizontal">
                 	
                    <div class="panel-body">
                    	{{ csrf_field() }}
          
              			<fieldset>
                		@include('layouts.includes.errors')
                        
                        <div class="form-group">
              <label class="col-lg-3 control-label">Bank Name</label>
              <div class="col-lg-5">
                <input type="text" class="form-control" value="{{ $bank->bank_name }}" name="bank_name" placeholder="Bank Name" required>
              </div>
            </div>
                        
                         
                      <div class="form-group">
              <label class="col-lg-3 control-label">Account Name</label>
              <div class="col-lg-5">
                <input type="text" class="form-control" value="{{ $bank->account_name }}" name="account_name" placeholder="Account Name" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Account Number</label>
              <div class="col-lg-5">
                <input type="number" id="p2" class="form-control" min="1" name="account_number" value="{{ $bank->account_number }}" placeholder="Account Number" required>
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
        </div>
          
                </div>
  @endsection
  @section('scripts')
    <script type='text/javascript' src="{{ asset('js/jquery-2.2.1.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/bootstrap.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/nifty.min.js?v=1.1') }}"></script>
  @endsection