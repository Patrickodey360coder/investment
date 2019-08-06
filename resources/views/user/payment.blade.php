@extends('layouts.user.app')
  @section('title')
    Make Payment
  @endsection

  @section('page-content')
  	<div class="panel" style="overflow: hidden">
        <div class="panel-body">
          <div class="panel container">
            <div class="panel-body row-fluid">
              <div class="col-xs-6">
                <h3 class="text-center">Option 1</h3>
                <h3 class="text-center">Pay in bank and contact customer care to verify your payment</h3>
                <h4>Bank Name: Sterling Bank</h4>
                <h4>Account Name: Trustway Capital Limited</h4>
                <h4>Account Number: 0073013892</h4>
              </div>
              <div class="col-xs-6">
                <h3 class="text-center">Option 2</h3>
                <h3 class="text-center">Pay Online</h3>
                <form class="form-horizontal" id="payment">
                  <fieldset>
                    <div class="form-group">
                      <label for="amount" class="col-lg-4 control-label">Amount You Want To Pay</label>
                      <div class="col-lg-6">
                          <input type="number" min="1" step=".01" class="form-control" required name="amount" id="amount" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-6 col-lg-offset-4">
                        <button class="btn btn-success btn-labeled btn-block fa fa-send fa-lg" type="submit">Pay Online</button>
                        <button
                          type="button"
                          name="shockinflux-inline-btn"
                          id="shockinflux"
                          class="hidden"
                          data-amount="0"
                          data-email="{{ Auth::user()->email }}"
                          data-template="clean"
                          data-currency="ngn"
                          data-language="en"
                          data-action="undefined"
                          data-transactionid="00000"
                          data-storeid="g1xq8y87y800000U2FsdGVkX1/LaykxunCYjDqjtawGReF+0CLekeY8v7YNA3U4jjYZo4OMehhOt5WpudyuTJYG2AACiy/JNw1IhlfCFVYDF3B7Hu0AHU4qOsLiAh15Kkal7dF8zi7Sb0g9HHhXo7q4X3FYeRERDjGqnCa0gOBmcjyn/niZtvb01Rtt5Ugcg5CUpIAWmZShwKgLyerrG1vrwuSqEischxDKapM5avW9XBJbKXuZo+x3uqw="
                          data-comment="Comment for Payment"
                          data-callback="function ace(response){console.log(response)}"
                          class="shockinflux-inline-btn" >
                          Make Payment
                        </button >
                      </div>
                    </div>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  @endsection

  @section('scripts')
    <script type="text/javascript">
      var amount = document.getElementById('amount');
      var shockinflux = document.getElementById('shockinflux');

      document.getElementById('payment').addEventListener('submit', function(evt){
        evt.preventDefault();
        console.log('evt',evt);
        console.log('this',amount.value);
        shockinflux.dataset['amount'] = amount.value;
        shockinflux.click();
        
      })
    </script>
    <script src="https://scripts-cdn.boxedall.com/shockinflux/v2/payview/js/shockpayment_client.js" charset="utf-8"> </script>
    <script> shock_init("shockinflux"); </script> 
    <script type='text/javascript' src="{{ asset('/js/jquery-2.2.1.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('/js/bootstrap.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('/js/nifty.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('/plugins/fast-click/fastclick.min.js?v=1.1') }}"></script>
  @endsection