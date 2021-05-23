<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor_node;
use App\Models\Sensor;
use Illuminate\Support\Facades\Validator;

class sensorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sensors = Sensor_node::all();

        return view('main.sensors')->with(['sensors' => $sensors]);
    }

    public function show_single($id)
    {
        $sensor_s = Sensor::where('sensor_node_id', '=', $id)->get();
        $sen = Sensor_node::find($id);

        return view('main.sensor_single', compact('sensor_s', 'sen'));
    }

    public function show_create()
    {
        return view('main.create_sensor');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect('/sensors/create')->with(['error' => 'Sensor is not Added to System']);
        }

        $sensor_nodes = Sensor_node::where("name", "=", $request->name)->get();
        if ($sensor_nodes->count() > 0) {
            return redirect('/sensors/create')->with(['error' => 'Sensor with the name ' . $request->name . ' Already Exist, Try Another']);
        } else {
            $sensor_node = Sensor_node::create(['name' => $request->name]);
            if ($sensor_node) {
                return redirect('/sensors')->with(['message' => 'Sensor ' . $request->name . ' is added to System']);
            } else {
                return redirect('/sensors/create')->with(['error' => 'Sensor is not Added to System']);
            }
        }
    }
}
