@extends('layouts.user.app')
  @section('title')
    Withdrawal Requests
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
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                  </select>
                </div>
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
              <th data-toggle="true">#</th>
              <th>User</th>
              <th>Amount</th>
              <th>Status</th>
              <th data-hide="phone, tablet">Date created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @if(count($withdrawals) > 0)
              <?php $count=1; ?>
              @foreach($withdrawals as $withdrawal)
                <tr>
                  <td>{{ $count++ }}</td>
                  <td>{{ $withdrawal->user->name }} ({{ $withdrawal->user->email }})</td>
                  <td>&#8358;{{ $withdrawal->amount }}</td>
                  <td>
                    @if($withdrawal->status == 'Paid')
                      <span class="label label-table label-success">
                    @elseif($withdrawal->status == 'Rejected')
                      <span class="label label-table label-dark">
                    @elseif($withdrawal->status == 'Pending')
                      <span class="label label-table label-danger">
                    @endif
                      {{ $withdrawal->status }}
                    </label>
                  </td>
                  <!-- DATE FORMAT: 16th of July, 2016 12:00 am -->
                  <td>{{ $withdrawal->created_at }}</td>
                  <td>
                    @if($withdrawal->status == 'Pending')
                      <a href="{{ route('admin.accept.withdrawals', ['id' => $withdrawal->id]) }}" class="btn btn-success">Accept</a>&nbsp;
                      <a href="{{ route('admin.reject.withdrawals', ['id' => $withdrawal->id]) }}" class="btn btn-danger">Reject</a>
                    @endif
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="5">
                  <h3 class="text-center">You don't have any withdrawal request.</h3>
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

      $('#demo-foo-search').on('input', function (e) {
        e.preventDefault();
        filtering.trigger('footable_filter', {filter: $(this).val()});
      });

        
        </script>
  @endsection