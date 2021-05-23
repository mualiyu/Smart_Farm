<?php

namespace App\Http\Controllers;

use App\Events\chartData;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;

class mainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        event(new chartData('my new message'));

        $sensor1 = Sensor::where('sensor_node_id', '=', 1)->orderBy("created_at", "desc")->get();
        $sensor2 = Sensor::where('sensor_node_id', '=', 2)->orderBy("created_at", "desc")->get();

        $date_r1 = [];
        foreach ($sensor1 as $s1) {
            $sdate = $s1->created_at;
            $ex_date = explode(" ", $sdate);
            $date_c = $ex_date[0];
            array_push($date_r1, $date_c);
        }
        $node1_created_at = array_unique($date_r1);

        $date_r2 = [];
        foreach ($sensor2 as $s2) {
            $sdate = $s2->created_at;
            $ex_date = explode(" ", $sdate);
            $date_c = $ex_date[0];
            array_push($date_r2, $date_c);
        }
        $node2_created_at = array_unique($date_r2);

        // foreach ($created_at as $c_at) {
        //     $start = $c_at . " 00:00:01";
        //     $stop = $c_at . " 24:59:59";

        //     $sens1 = Sensor::whereBetween('created_at', [$start,  $stop])->first();
        // }


        // dd($node1);

        return view('main.index', compact('node1_created_at', 'node2_created_at'));
    }
}
