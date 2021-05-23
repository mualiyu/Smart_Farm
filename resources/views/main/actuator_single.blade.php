@extends('layouts.index')

@section('style')  
  <style>
    #switch[type=checkbox]{
    	height: 0;
    	width: 0;
    	visibility: hidden;
    }

    #vv {
    	cursor: pointer;
    	text-indent: -9999px;
    	width: 60px;
    	height: 30px;
    	background: grey;
    	display: block;
    	border-radius: 30px;
    	position: relative;
      margin-left: 5px;
    }

    #vv:after {
    	content: '';
    	position: absolute;
    	top: 1px;
    	left: 1px;
    	width: 25px;
    	height: 28px;
    	background: #fff;
    	border-radius: 15px;
    	transition: 0.2s;
    }

    #switch:checked + #vv {
    	background: green;
    }

    #switch:checked + #vv:after {
    	left: calc(100% - 2px);
    	transform: translateX(-100%);
    }

    #vv:active:after {
    	width: 40px;
    }
  </style>
@endsection

@section('content')
    <div class="container-fluid">
      <h1 class="mt-4">{{$actuator_s->name}} Detail</h1>
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
                  <th>Sensor Name</th>
                  <th>
                    <table style="margin:0px; width:100%; padding:0px; height:20px;">
                      <tbody>
                        <tr>
                          <td colspan="2" style="text-align: center">Location</td>
                        </tr>
                        <tr>
                          <td style="width:50%;">longitude</td>
                          <td style="width:50%;">latitude</td>
                        </tr>
                      </tbody>
                    </table>
                  </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @if ($actuator_s)
                      <tr>
                        <td>{{$actuator_s->name}}</td>
                        <td>
                          <table style="margin:0px; width:100%; padding:0px; height:;">
                            <tbody>
                              <tr>
                                <td style="width:50%;">{{$location->longitude}}</td>
                                <td style="width:50%;">{{$location->latitude}}</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td>
                          <input
                            id="switch"
                            data-id="{{$system_status->mode}}"
                            {{$system_status->mode ? "disabled" : ""}}
                            class="toggle-class"
                            type="checkbox"
                             data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $system_status->pump ? 'checked' : '' }}
                          /><label id="vv" for="switch" >Toggle</label>
                        </td>
                      </tr>
                  @else
                      <tr>
                        <td style="text-align: center" colspan="2">No Data!</td>
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