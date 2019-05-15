@extends('layouts.user.app')
  @section('title')
    All Investors
  @endsection
  @section('page-content')
    <div class="panel">
      <div class="panel-body">
        <table id="demo-foo-filtering" class="table table-bordered table-hover toggle-circle" data-page-size="20">
          <div class="pad-btm form-inline">
            <div class="row">
              <div class="col-sm-6 text-xs-center">
              </div>
              <div class="col-sm-6 text-xs-center text-right">
                <div class="form-group">
                  <input id="demo-foo-search" type="text" placeholder="Search" class="form-control" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <thead>
            <tr>
              <th>Full Name</th>
              <th data-hide="phone, tablet">Email</th>
              <th data-hide="phone, tablet">Country</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @if(count($investors) > 0)
              @foreach($investors as $investor)
                <tr>
                  <td>{{ $investor->name }}</td>
                  <td>{{ $investor->email }}</td>
                  <td>{{ $investor->country }}</td>
                  <td>
                    <button class="btn btn-info investor-payment" data-name="{{ $investor->name }}" data-href="{{ route('admin.user.payments', ['id' => $investor->id]) }}" data-toggle="modal" data-target="#paymentModal">Add &nbsp; Payment</button>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="5">
                  <h3 class="text-center">They are no registered investors.</h3>
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
    <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#paymentModal">More Info</button>

    <div id="paymentModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Incoming Investor Payment</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div><!-- modal-header -->
          <form class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                <fieldset>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Amount</label>
                    <div class="col-lg-6">
                        <input type="number" class="form-control" required name="amount" step="any" min="0" id="amount" placeholder="Enter the amount you received">
                    </div>
                  </div>
                </fieldset>
            </div><!-- modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Back</button>
            </div><!-- modal-footer -->
          </form>
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal fade -->
  @endsection
  @section('scripts')
    <script type='text/javascript' src="{{ asset('js/jquery-2.2.1.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/bootstrap.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/nifty.min.js?v=1.1') }}"></script>
        
        <script type='text/javascript' src="{{ asset('plugins/fast-click/fastclick.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('plugins/fooTable/dist/footable.all.min.js?v=1.1') }}"></script>
            
          <script>
            var investorPaymentBtns = document.getElementsByClassName('investor-payment');
            var paymentModalHeading = document.querySelector('#paymentModal h5');
            var paymentModalform = document.querySelector('#paymentModal form');

            for (var i = 0; i < investorPaymentBtns.length; i++) {
              investorPaymentBtns[i].addEventListener('click', function(evt){
                evt.preventDefault();
                paymentModalHeading.innerHTML = "Add Incoming Payment for " + evt.target.dataset.name;
                paymentModalform.action = evt.target.dataset.href;
              })
            }
          
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