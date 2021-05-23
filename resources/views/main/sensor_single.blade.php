@extends('layouts.index')

@section('content')
    <div class="container-fluid">
            <h1 class="mt-4">{{$sen->name}} Detail</h1>

            <div class="card mb-4">
              <div class="card-body">
                  <div class="row">
                      <div class="col-3">
                          <button onclick="window.history.go(-1)" class="btn btn-secondary"><i class="fas fas-goto"></i> Back</button>
                      </div>
                      <div class="col-3"></div>
                      <div class="col-3"></div>
                      <div class="col-3"></div>
                  </div>
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
                        <th>Moisture</th>
                        <th>Humidity</th>
                        <th>Temperature</th>
                        <th>Timestamp</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if ($sensor_s->count() > 0)
                            @foreach ($sensor_s as $s)
                            <tr>
                              <td>{{$s->moisture}}</td>
                              <td>{{$s->humidity}}</td>
                              <td>{{$s->temperature}}</td>
                              <td>{{$s->created_at ?? " "}}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                              <td style="text-align: center" colspan="4">No Data!</td>
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
 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
 <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
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