@extends('layouts.user.app')
  @section('title')
    Create Trustway Investment
  @endsection
  @section('page-content')
    <div class="panel">
      <div class="panel-body">
        <div class="panel">
          <div class="panel-body">
            <form id="demo-bvd-notempty" action="{{ route('user.create-trustway-investments.store') }}" method="post" class="form-horizontal">
              {{ csrf_field() }}
          
              <fieldset>
                @include('layouts.includes.errors')
                <div class="form-group">
                  <label class="col-lg-3 control-label">Type of Investment</label>
                  <div class="col-lg-4">
                    <select data-placeholder="Choose an investor" class="form-control" required name="investment-type" id="demo-chosen-select" tabindex="2">
                      <option value="">Please select an investment</option>
                      @foreach($investments as $investment)
                      <option value="{{ $investment }}">{{ $investment }}</option>
                      @endforeach
                    </select>       
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Amount</label>
                  <div class="col-lg-4">
                      <input type="number" step="any" class="form-control" required name="amount" id="amount" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Duration</label>
                  <div class="col-lg-4">
                    <input type="text" class="form-control" id="durationInput" disabled placeholder="">
                    <select data-placeholder="Choose an investor" class="form-control hidden" name="duration" id="durationSelect" tabindex="2">
                      <option value="2">2 years</option>
                      <option value="3">3 years</option>
                      <option value="4">4 years</option>
                      <option value="5">5 years</option>
                      <option value="6">6 years</option>
                      <option value="7">7 years</option>
                      <option value="8">8 years</option>
                      <option value="9">9 years</option>
                      <option value="10">10 years</option>
                    </select>  
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Total Earnings</label>
                  <div class="col-lg-4">
                      <input type="text" class="form-control" name="earnings" id="earnings" disabled placeholder="">
                  </div>
                </div>
              </fieldset>
              <div class="panel-footer">
                <div class="row">
                  <div class="col-sm-7 col-sm-offset-3">
                    <button class="btn btn-primary btn-labeled fa fa-send fa-lg" type="submit">Submit</button>
                  </div>
                </div>
              </div>
            </form>
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
    <script type="text/javascript">
      var wallet = {{ $wallet['withdrawable'] }};
      var ROI = 0;
      var selectElem = document.getElementById('demo-chosen-select');
      var amountElem = document.getElementById('amount');
      var earningsElem = document.getElementById('earnings');
      var durationInputElem = document.getElementById('durationInput');
      var durationSelectElem = document.getElementById('durationSelect');

      amountElem.addEventListener('input', function(evt){
        setUpTotalEarnings(evt.target.value);
      });

      document.getElementById('demo-bvd-notempty').addEventListener('submit', function(evt){
        if(amountElem.value > wallet){
          evt.preventDefault();
          alert('Please your current balance in your wallet can not support this investment');
        }
      })

      durationSelectElem.addEventListener('change', function(evt){
        setUpTotalEarnings(amountElem.value);
      })

      selectElem.addEventListener('change', function(evt){
        switch (evt.target.value) {
          case 'Quantum 250':
            ROI = 25;
            setUpDurationField(3, 25000, 500000);
            setUpTotalEarnings(amountElem.value);
            break;
          case 'Trustway 30':
            ROI = 3.5;
            setUpDurationField(1, 25000, 500000);
            setUpTotalEarnings(amountElem.value);
            break;
          case 'Trustway 90':
            ROI = 15;
            setUpDurationField(3, 25000, 500000);
            setUpTotalEarnings(amountElem.value);
            break;
          case 'Trustway 180':
            ROI = 40;
            setUpDurationField(6, 25000, 1000000);
            setUpTotalEarnings(amountElem.value);
            break;
          case 'Trustway 360':
            ROI = 90;
            setUpDurationField(12, 50000, 1000000);
            setUpTotalEarnings(amountElem.value);
            break;
          case 'Trustway Pension':
            ROI = 100;
            durationInputElem.classList.add('hidden');
            durationSelectElem.classList.remove('hidden');
            durationSelectElem.required = true;
            amountElem.min = 100000;
            setUpTotalEarnings(amountElem.value);
            break;
          default:
            ROI = 0;
            durationInputElem.value = '';
            setUpTotalEarnings();
            break;
        }
      });

      function setUpTotalEarnings(amount){
        amount = parseInt(amount) || 0;
        if(selectElem.value === 'Trustway Pension'){
          earningsElem.value = calc(amount, durationSelectElem.value);
        } else {
          earningsElem.value = ROI ? amount + (amount * ROI/100) : '';
        }
      }

      function calc(amount, years){
        capital = parseInt(amount);
        totalEarning = 0;

        for(var i=0; i<years; i++){
          totalEarning += capital * 75/100;
          capital += capital * 25/100;
        }
        totalEarning += capital;  

        return totalEarning.toFixed(2);
      }

      function setUpDurationField(months, minAmount) {
        durationInputElem.value = months + " months";
        durationInputElem.classList.remove('hidden');
        durationSelectElem.classList.add('hidden');
        durationSelectElem.required = false;
        amountElem.min = minAmount;
      }
    </script>
  @endsection