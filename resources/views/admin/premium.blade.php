@extends('layouts.user.app')
  @section('title')
    All Investors
  @endsection
  @section('page-content')
    <div class="panel">
      <div class="panel-body">
        @include('layouts.includes.errors')
        <table id="demo-foo-filtering" class="table table-bordered table-hover toggle-circle" data-page-size="20">
          <thead>
            <tr>
              <th>Full Name</th>
              <th data-hide="phone, tablet">Email</th>
              <th data-hide="phone, tablet">Country</th>
              <th>Actions</th>
            </tr>
          </thead>
          <div class="pad-btm form-inline">
            <div class="row">
              <div class="col-sm-6 text-xs-center">
                <div class="form-group">
                  <label class="control-label"></label>
                  <select id="demo-foo-filter-status" class="form-control">
                    <option value="">Show all</option>                  
                  </select>
                </div>
              </div>
              <div class="col-sm-6 text-xs-center text-right">
                <button class="btn btn-success" data-toggle="modal" data-target="#premiumModal">Create Premium Investor</button>
                <div class="form-group">
                  <input id="demo-foo-search" type="text" placeholder="Search" class="form-control" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <tbody>
            @if(count($investors) > 0)
              @foreach($investors as $investor)
                <tr>
                  <?php
                    $bank = $investor->bankAccount;
                    $bankName = empty($bank->bank_name) ? 'Not yet set' : $bank->bank_name;
                    $accountName = empty($bank->account_name) ? 'Not yet set' : $bank->account_name;
                    $accountNumber = empty($bank->account_number) ? 'Not yet set' : $bank->account_number;
                  ?>
                  <td>{{ $investor->name }}</td>
                  <td>{{ $investor->email }}</td>
                  <td>{{ $investor->country }}</td>
                  <td>
                    <button class="btn btn-info investor-bank" data-name="{{ $investor->name }}" data-bankName="{{ $bankName }}" data-accountName="{{ $accountName }}" data-accountNumber="{{ $accountNumber }}" data-toggle="modal" data-target="#bankModal">View Bank Details</button>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="5">
                  <h3 class="text-center">They are no registered premium investors.</h3>
                </td>
              </tr>
            @endif
          </tbody>
          <tfoot>
            <tr>
              <td colspan="8">
              <div class="text-right">
                <ul class="pagination"></ul>
              </div>  
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div id="bankModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Bank Details</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div><!-- modal-header -->
          <div class="modal-body">
            <h4>Bank Name: <span id="bankName"></span></h4>
            <h4>Account Name: <span id="accountName"></span></h4>
            <h4>Account Number: <span id="accountNumber"></span></h4>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Back</button>
          </div><!-- modal-footer -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div>
    <div id="premiumModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add a Premium Investor</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div><!-- modal-header -->
          <form class="form-horizontal" action="{{ route('admin.premium.users.create') }}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                <fieldset>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Email</label>
                    <div class="col-lg-6">
                      <input type="email" class="form-control" required name="email" placeholder="Email Address">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Amount Invested</label>
                    <div class="col-lg-6">
                      <input type="number" class="form-control" required name="investment_amount" step="any" min="1" placeholder="Enter the amount invested by the user">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Investment start date</label>
                    <div class="col-lg-4">
                      <div class="input-group date">
                        <input autocomplete="off" type="text" name="investment_date" id="pikaday" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Duration (months)</label>
                    <div class="col-lg-6">
                      <input type="number" class="form-control" required name="months" step="1" min="1" placeholder="Enter the number of months the investment should last">
                    </div>
                  </div>
                </fieldset>
            </div><!-- modal-body -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Submit</button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Back</button>
            </div><!-- modal-footer -->
          </form>
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div>
  @endsection
  @section('scripts')
    <link rel='stylesheet' href="{{ asset('css/pikaday.css?') }}" type='text/css' media='all' />
    <script type='text/javascript' src="{{ asset('js/jquery-2.2.1.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/bootstrap.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/nifty.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/pikaday.js') }}"></script>
        
        <script type='text/javascript' src="{{ asset('plugins/fast-click/fastclick.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('plugins/fooTable/dist/footable.all.min.js?v=1.1') }}"></script>
            
          <script>
            var bankModalHeading = document.querySelector('#bankModal h5');
            var accountName = document.getElementById('accountName');
            var accountNumber = document.getElementById('accountNumber');
            var bankName = document.getElementById('bankName');

            var investorBankBtns = document.getElementsByClassName('investor-bank');

            for (var i = 0; i < investorBankBtns.length; i++) {
              investorBankBtns[i].addEventListener('click', function(evt){
                evt.preventDefault();
                bankModalHeading.innerHTML = "Bank Details for " + evt.target.dataset.name;
                accountNumber.innerHTML = evt.target.dataset.accountnumber;
                accountName.innerHTML = evt.target.dataset.accountname;
                bankName.innerHTML = evt.target.dataset.bankname;
              })
            }

            var picker = new Pikaday({ 
              field: document.getElementById('pikaday'),
              format: "YYYY-MMM-D",
              minDate: new Date("{{ $minInvestmentDate }}"),
              maxDate: new Date("{{ $maxInvestmentDate }}")
            });
          
          var filtering = $('#demo-foo-filtering');
      filtering.footable().on('footable_filtering', function (e) {
        var selected = $('#demo-foo-filter-status').find(':selected').val();
        e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
        e.clear = !e.filter;
      });

      // Filter status
      $('#demo-foo-filter-status').change(function (e) {
        e.preventDefault();
        filtering.trigger('footable_filter', {filter: $(this).val()});
      });

      // Search input
      $('#demo-foo-search').on('input', function (e) {
        e.preventDefault();
        filtering.trigger('footable_filter', {filter: $(this).val()});
      });

        
        </script>
  @endsection