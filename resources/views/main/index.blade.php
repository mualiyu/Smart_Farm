@extends('layouts.index')

@section('content')
    <div class="container-fluid">
      <h1 class="mt-4">Home</h1>
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
          <div class="row">
            <div class="col-md-6 py-1" id="chartDiv">
              <h3 style="text-align: center">Node 1</h3>
              <div class="llk">
              <?php 
                $node1_c_at = [];
                $counter = 0;
                foreach ($node1_created_at as $node_r) {
                  if ($counter < 7) {
                    array_push($node1_c_at, $node_r);
                  }
                  $counter++;
                }
                // print_r(count($node1_c_at));
                $temperature = [];
                $humidity = [];
                $moisture = [];
                for ($i=0; $i < count($node1_c_at); $i++) { 
                  $node1 = \App\Models\Sensor::whereBetween("created_at", [$node1_c_at[$i]." 00:00:01", $node1_c_at[$i]. " 23:59:59"])->orderBy('created_at', 'desc')->first();
                  
                  array_push($temperature, $node1->temperature);
                  array_push($humidity, $node1->humidity);
                  if ($node1->moisture < 0) {
                    $mois = explode("-",  $node1->moisture);
                    $moisture_a = $mois[1];
                  }else {
                    $moisture_a = $node1->moisture;
                  }
                  array_push($moisture, $moisture_a);
                  // print_r($node1->moisture);
                }
                $count_t = count($temperature);
                for ($i=0; $i < 8; $i++) { 
                  if ($count_t < $i) {
                    array_push($temperature, "0");
                    array_push($humidity, "0");
                    array_push($moisture, "0");
                  }
                }
                $temperature = array_reverse($temperature);
                $humidity = array_reverse($humidity);
                $moisture = array_reverse($moisture);

                // print_r($temperature)

              ?>
              <canvas id="chLine"></canvas>
              </div>
            </div>
            <div class="col-md-6 py-1" id="chartDiv2">
              <?php 
                $node2_c_at = [];
                $counter2 = 0;
                foreach ($node2_created_at as $node_r) {
                  if ($counter2 < 7) {
                    array_push($node2_c_at, $node_r);
                  }
                  $counter2++;
                }
                // print_r(count($node1_c_at));
                $temperature2 = [];
                $humidity2 = [];
                $moisture2 = [];
                for ($i=0; $i < count($node2_c_at); $i++) { 
                  $node2 = \App\Models\Sensor::whereBetween("created_at", [$node2_c_at[$i]." 00:00:01", $node2_c_at[$i]. " 23:59:59"])->orderBy('created_at', 'desc')->first();
                  
                  array_push($temperature2, $node2->temperature);
                  array_push($humidity2, $node2->humidity);
                  if ($node2->moisture < 0) {
                    $mois2 = explode("-",  $node2->moisture);
                    $moisture_a2 = $mois2[1];
                  }else {
                    $moisture_a2 = $node2->moisture;
                  }
                  array_push($moisture2, $moisture_a2);
                  // print_r($node1->moisture);
                }
                $count_t2 = count($temperature2);
                for ($i=0; $i < 8; $i++) { 
                  if ($count_t2 < $i) {
                    array_push($temperature2, "0");
                    array_push($humidity2, "0");
                    array_push($moisture2, "0");
                  }
                }
                $temperature2 = array_reverse($temperature2);
                $humidity2 = array_reverse($humidity2);
                $moisture2 = array_reverse($moisture2);

//date to Days converter for node 2 
$date = strtotime($node1_created_at[0]);
$date_y = date('y', $date);
$date_m = date('m', $date);
$date_d = date('d', $date);
$days_n1 = [];
for ($i=0; $i < 7; $i++) { 
  // $date_s = $date_f-$i;
  $date_s = date('d-m-Y',mktime(0,0,0,$date_m,($date_d-$i),$date_y));
  $date_l = strtotime($date_s);
  $day = date('l', $date_l);
  array_push($days_n1 , $day);
}
$days_n1_r = array_reverse($days_n1);
// print_r($days_n1_r);

//date to Days converter for node 2 
$date_n2 = strtotime($node1_created_at[0]);
$date_y_n2 = date('y', $date_n2);
$date_m_n2 = date('m', $date_n2);
$date_d_n2 = date('d', $date_n2);
$days_n2 = [];
for ($i=0; $i < 7; $i++) { 
  // $date_s = $date_f-$i;
  $date_s = date('d-m-Y',mktime(0,0,0,$date_m_n2,($date_d_n2-$i),$date_y_n2));
  $date_l = strtotime($date_s);
  $day = date('l', $date_l);
  array_push($days_n2 , $day);
}
$days_n2_r = array_reverse($days_n2);
// print_r($days_n2);
// print_r($days_n2_r);
              ?>
              <h3 style="text-align: center">Node 2</h3>
              <canvas id="chLine2"></canvas>
            </div>
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
    <script>
     
//Line Chart Node 1
const labels = [<?php for($i=0; $i<7; $i++){ echo "'".$days_n1_r[$i]."', ";} ?>];
const data = {
  labels: labels,
  datasets: [
    {
      label: "Temperature",
      backgroundColor: "rgb(62, 60, 180)",
      borderColor: "rgb(62, 60, 180)",
      data: [<?php for($i=0; $i<7; $i++){ echo $temperature[$i]. ", ";} ?>],
    },
    {
      label: "Humidity",
      backgroundColor: "rgb(255, 99, 132)",
      borderColor: "rgb(255, 99, 132)",
      data: [<?php for($i=0; $i<7; $i++){ echo $humidity[$i]. ", ";} ?>],
    },
    {
      label: "Moisture",
      backgroundColor: "rgb(0,128,0)",
      borderColor: "rgb(0,128,0)",
      data: [<?php for($i=0; $i<7; $i++){ echo $moisture[$i]. ", ";} ?>],
    },
  ],
};

const config = {
  type: "line",
  data: data,
  options: {
    responsive: true,
  },
};


//Line Chart
const label = [<?php for($i=0; $i<7; $i++){ echo "'".$days_n2_r[$i]."', ";} ?>];
const datA = {
  labels: label,
  datasets: [
    {
      label: "Temperature",
      backgroundColor: "rgb(62, 60, 180)",
      borderColor: "rgb(62, 60, 180)",
      data: [<?php for($i=0; $i<7; $i++){ echo $temperature2[$i]. ", ";} ?>],
    },
    {
      label: "Humidity",
      backgroundColor: "rgb(255, 99, 132)",
      borderColor: "rgb(255, 99, 132)",
      data: [<?php for($i=0; $i<7; $i++){ echo $humidity2[$i]. ", ";} ?>],
    },
    {
      label: "Moisture",
      backgroundColor: "rgb(0,128,0)",
      borderColor: "rgb(0,128,0)",
      data: [<?php for($i=0; $i<7; $i++){ echo $moisture2[$i]. ", ";} ?>],
    },
  ],
};

const confiG = {
  type: "line",
  data: datA,
  options: {
    responsive: true,
  },
};


var myChart = new Chart(document.getElementById("chLine"), config);
var myCharT = new Chart(document.getElementById("chLine2"), confiG);

    </script>

@endsection