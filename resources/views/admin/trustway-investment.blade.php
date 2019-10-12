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
                      <a style="margin-top: 5px;" href="{{ route('admin.activate.investments', ['id' => $investment->id]) }}" class="btn btn-success">Activate</a>
                      <button style="margin-top: 5px;" class="btn btn-info activate-investment" data-investment_type="{{ $investment->investment_type }}" data-href="{{ route('admin.activate.investments', ['id' => $investment->id]) }}" data-toggle="modal" data-target="#activateModal">Change Activation Date</button>
                    @endif
                    <a style="margin-top: 5px;" onclick="return confirm('Are you sure you want to delete this investment');" href="{{ route('admin.delete.investments', ['id' => $investment->id]) }}" class="btn btn-danger">Delete</a>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="9">
                  <h2 class="text-center">They are no Trustway Investments</h2>
                </td>
              </tr>
            @endif
          </tbody>
          <tfoot>
            <tr>
              <td colspan="9">
              <div class="text-right">
                <ul class="pagination"></ul>
              </div>  
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div id="activateModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Activate Investment</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div><!-- modal-header -->
          <form class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="form-group">
                <label class="col-lg-3 control-label">Investment start date</label>
                <div class="col-lg-4">
                    <div class="input-group date">
                      <input autocomplete="off" type="text" name="date" id="pikaday" class="form-control">
                      <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                    </div>
                </div>
              </div>
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
    <link rel='stylesheet' href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.css?') }}" type='text/css' media='all' />
    <link rel='stylesheet' href="{{ asset('css/pikaday.css?') }}" type='text/css' media='all' />
    <script type='text/javascript' src="{{ asset('js/jquery-2.2.1.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/bootstrap.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/nifty.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('js/pikaday.js') }}"></script>
        
        <script type='text/javascript' src="{{ asset('plugins/fast-click/fastclick.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('plugins/fooTable/dist/footable.all.min.js?v=1.1') }}"></script>
    <script type='text/javascript' src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
            
          <script>
            var picker;
            var minDate;
            var threeMonths = new Date("{{ $threeMonths }}");
            var sixMonths = new Date("{{ $sixMonths }}");
            var oneYear = new Date("{{ $oneYear }}");

            var activateInvestmentBtns = document.getElementsByClassName('activate-investment');
            var activateInvestmentModalform = document.querySelector('#activateModal form');
            
            for (var i = 0; i < activateInvestmentBtns.length; i++) {
              activateInvestmentBtns[i].addEventListener('click', function(evt){
                switch (evt.target.dataset.investment_type) {
                  case 'Trustway 90':
                    minDate = threeMonths;
                    break;
                  case 'Trustway 180':
                    minDate = sixMonths;
                    break;
                  case 'Trustway 360':
                  case 'Trustway Pension':
                    minDate = oneYear;
                    break;
                  default:
                    break;
                }
                activateInvestmentModalform.action = evt.target.dataset.href;
                picker && picker.destroy && picker.destroy();
                picker = new Pikaday({ 
                  field: document.getElementById('pikaday'),
                  format: "YYYY-MMM-D",
                  minDate: minDate,
                  maxDate: new Date(),
                });
              })
            }

          $('#demo-dp-component .input-group.date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            minDate: '05/28/2019 1:46 PM'
          });
          //$('#demo-dp-component .input-group.date').data("DateTimePicker").minDate('05/28/2019 1:46 PM')
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