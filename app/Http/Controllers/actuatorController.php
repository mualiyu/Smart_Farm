<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actuator_node;
use App\Models\Actuator;
use App\Models\Gps_location;
use Illuminate\Support\Facades\Validator;
use App\Models\System_status;

class actuatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $actuators = Actuator_node::all();
        $system_status = System_status::orderBy('created_at', 'desc')->first();

        return view('main.actuators')->with(['actuators' => $actuators, "system_status" => $system_status]);
    }

    public function show_single($id)
    {
        $actuator_s = Actuator_node::find($id);
        // $act = Actuator_node::find($id);
        $system_status = System_status::orderBy('created_at', 'desc')->first();

        $location = Gps_location::orderBy('created_at', 'desc')->first();

        return view("main.actuator_single", compact('actuator_s', 'system_status', 'location'));
    }

    public function show_create()
    {
        return view('main.create_actuator');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect('/actuators/create')->with(['error' => 'Actuator is not Added to System']);
        }

        $actuator_nodes = Actuator_node::where("name", "=", $request->name)->get();
        if ($actuator_nodes->count() > 0) {
            return redirect('/actuators/create')->with(['error' => 'Actuator with the name ' . $request->name . ' Already Exist, Try Another']);
        } else {
            $actuator_node = Actuator_node::create(['name' => $request->name]);
            if ($actuator_node) {
                return redirect('/actuators')->with(['message' => 'Actuator ' . $request->name . ' is added to System']);
            } else {
                return redirect('/actuators/create')->with(['error' => 'Actuator is not Added to System']);
            }
        } // dd($request->all());
        print_r($request->name);
    }
}
