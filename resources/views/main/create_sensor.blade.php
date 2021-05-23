@extends('layouts.index')

@section('content')
 <div class="container-fluid">
      <h1 class="mt-4">Sensor</h1>
      <br>
      <div class="row">
          <div class="col-3">
              <button onclick="window.history.go(-1)" class="btn btn-secondary"><i class="fas fas-goto"></i> Back</button>
          </div>
          <div class="col-3"></div>
          <div class="col-3"></div>
          <div class="col-3"></div>
      </div>
      <br>
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
      <div class="row">
          <div class="col-3"></div>
          <div class="col-6">
            <div class="card mb-4">
                <div class="card-header">
                    Add Sensor
                </div>
                <div class="card-body">
                    <form action="{{route('store_sensor')}}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" placeholder="Sensor Name" aria-label="Sensor name" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="button-addon2">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
          <div class="col-3"></div>
      </div>
    </div>
@endsection