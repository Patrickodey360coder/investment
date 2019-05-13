@extends('layouts.user.app')
  @section('title')
    Create Trustway Investment
  @endsection
  @section('page-content')
    <div class="panel">
      <div class="panel-body">
        <div class="panel">
                         <div class="panel-body">
                                                          <form id="demo-bvd-notempty" action="" method="post" class="form-horizontal">
                 
                             
                                <fieldset>
                                
                                <div class="form-group">
                      <label class="col-lg-3 control-label">Type of Investment</label>
                      <div class="col-lg-4">
                        <select data-placeholder="Choose an investor" class="form-control" required name="user" id="demo-chosen-select" tabindex="2">
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
                          <input type="number" class="form-control" required name="amount" id="amount" placeholder="">
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
                        </select>  
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Total Earnings</label>
                      <div class="col-lg-4">
                          <input type="text" class="form-control" name="earnings" id="earnings" disabled placeholder="">
                      </div>
                    </div>
                                
                                
                                 <!-- <div class="form-group">
                      <label class="col-lg-3 control-label">Date of payment</label>
                      <div class="col-lg-4">
                                    
                                      <div id="demo-dp-component">
                        <div class="input-group date">
                          <input type="text" name="date" class="form-control">
                          <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                        </div>
                        <small class="text-muted">Auto close on select</small>
                      </div>
                                         
                                  </div>
                    </div>
                                
                                 <div class="form-group">
                      <label class="col-lg-3 control-label">Time of payment</label>
                      <div class="col-lg-4">
                                       <div class="input-group date">
                      <input id="demo-tp-com" name="time" type="text" class="form-control">
                      <span class="input-group-addon"><i class="fa fa-clock-o fa-lg"></i></span>
                    </div>
                                  </div>
                    </div> -->
                                
                                        
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
    <script type='text/javascript' src='/js/jquery-2.2.1.min.js?v=1.1'></script>
    <script type='text/javascript' src='/js/bootstrap.min.js?v=1.1'></script>
    <script type='text/javascript' src='/js/nifty.min.js?v=1.1'></script>
    <script type='text/javascript' src='/plugins/fast-click/fastclick.min.js?v=1.1'></script>
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

      selectElem.addEventListener('change', function(evt){
        switch (evt.target.value) {
          case 'Trustway 90':
            ROI = 12;
            setUpDurationField(3, 25*1000, 500*1000);
            setUpTotalEarnings(amountElem.value);
            break;
          case 'Trustway 180':
            ROI = 30;
            setUpDurationField(6, 25*1000, 1000*1000);
            setUpTotalEarnings(amountElem.value);
            break;
          case 'Trustway 360':
            ROI = 75;
            setUpDurationField(12, 50*1000, 1000*1000);
            setUpTotalEarnings(amountElem.value);
            break;
          case 'Trustway Pension':
            ROI = 75;
            durationInputElem.classList.add('hidden');
            durationSelectElem.classList.remove('hidden');
            durationSelectElem.required = true;
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
        earningsElem.value = ROI ? amount + (amount * ROI/100) : '';
      }

      function setUpDurationField(months, minAmount, maxAmount) {
        durationInputElem.value = months + " months";
        durationInputElem.classList.remove('hidden');
        durationSelectElem.classList.add('hidden');
        durationSelectElem.required = false;
        amountElem.min = minAmount;
        amountElem.max = maxAmount;
      }
    </script>
  @endsection