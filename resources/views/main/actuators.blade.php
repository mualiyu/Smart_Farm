@extends('layouts.index')

@section('content')
    <div class="container-fluid">
            <h1 class="mt-4">List of Actuators</h1>
            @if (Session::has('error'))
                <div class="alert alert-warning">
                  <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="icon-remove"></i>
                  </button>
                  <strong>Warning!</strong> {{Session::get('error')}}
                </div>
            @endif
            @if (Session::has('message'))
                <div class="alert alert-success">
                  <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="icon-remove"></i>
                  </button>
                  <strong>Warning!</strong> {{Session::get('message')}}
                </div>
            @endif
            <div class="card mb-4">
              <div class="card-body">
                @if (Auth::user()->isAdmin())
                <div class="row">
                  <div class="col-3"></div>
                  <div class="col-3"></div>
                  <div class="col-3"></div>
                  <div class="col-3">
                    <a href="{{route('show_create_actuator')}}" class="btn btn-success">Add Actuator</a>
                  </div>
                </div>
                @endif
                <br>
                <div class="table-reponsive">
                  <table
                    class="table table-bordered"
                    id="dataTable"
                    width="100%"
                    cellspacing="0"
                  >
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Actuator Name</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if ($actuators->count() > 0)
                      <?php $i = 1; ?>
                          @foreach ($actuators as $actuator)
                              <tr>
                                <td>{{$i}}</td>
                                <td><a href="{{route('show_single_actuator',['id'=>$actuator->id])}}">{{$actuator->name}}</a></td>
                                <td>
                                  @if ($system_status->pump == 0)
                                    Off
                                  @else
                                      On
                                  @endif
                                </td>
                              </tr>
                              <?php $i++?>
                          @endforeach
                      @else
                          <tr>
                            <td style="text-align: center" colspan="3">No Data!</td>
                          </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // auto refresh page after 1 second
        setInterval('refreshPage()', 5000);
    });
 
    function refreshPage() { 
        location.reload(); 
    }
</script>
@endsection