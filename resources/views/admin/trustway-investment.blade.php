@extends('layouts.user.app')
  @section('title')
    Trustway Investments
  @endsection
  @section('page-content')
    <div class="panel">
      <div class="panel-body">
        <table id="demo-foo-filtering" class="table table-bordered table-hover toggle-circle" data-page-size="20">
          <div class="pad-btm form-inline">
            <div class="row">
              <div class="col-sm-6 text-xs-center">
                <div class="form-group">
                  <label class="control-label">Status</label>
                  <select id="demo-foo-filter-status" class="form-control">
                    <option value="">Show all</option>
                    <option value="active">Active</option>
                    <option value="closed">Closed</option>
                    <option value="pending">Pending</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <thead>
            <tr>
              <th data-toggle="true">#</th>
              <th>Investor</th>
              <th data-hide="phone, tablet">Investment Type</th>
              <th>Amount</th>
              <th data-hide="phone, tablet">Total Earnings</th> 
              <th>Status</th>
              <th data-hide="phone, tablet">Date created</th>
              <th data-hide="phone, tablet">Checkout Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @if(count($trustwayInvestments) > 0)
              <?php $count=1; ?>
              @foreach($trustwayInvestments as $investment)
                <tr>
                  <td>{{ $count++ }}</td>
                  <td>{{ $investment->user->name }}</td>
                  <td>{{ $investment->investment_type }}</td>
                  <td>&#8358;{{ $investment->investment_amount }}</td>
                  <td>&#8358;{{ $investment->checkout_amount }}</td>
                  <td>
                    @if($investment->status == 'Active')
                      <span class="label label-table label-success">
                    @elseif($investment->status == 'Closed')
                      <span class="label label-table label-dark">
                    @elseif($investment->status == 'Pending')
                      <span class="label label-table label-danger">
                    @endif
                      {{ $investment->status }}
                    </label>
                  </td>
                  <!-- DATE FORMAT: 16th of July, 2016 12:00 am -->
                  <td>{{ $investment->created_at }}</td>
                  <td>{{ $investment->checkout_date }}</td>
                  <td>
                    @if($investment->status == 'Pending')
                      <a href="{{ route('admin.activate.investments', ['id' => $investment->id]) }}" class="btn btn-success">Activate</a>
                    @endif
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="10">
                  <h2 class="text-center">You don't have any Trustway Investment</h2>
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
  @endsection
  @section('scripts')
    <script type='text/javascript' src="{{ asset('js/jquery-2.2.1.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/bootstrap.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/nifty.min.js?v=1.1') }}"></script>
        
        <script type='text/javascript' src="{{ asset('plugins/fast-click/fastclick.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('plugins/fooTable/dist/footable.all.min.js?v=1.1') }}"></script>
            
          <script>
          
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

        
        </script>
  @endsection