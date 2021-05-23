<?php

namespace App\Http\Controllers;

use App\Models\Actuator;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
use Symfony\Component\Console\Output\Output;
use App\Models\Actuator_node;
use App\Notifications\notifyAction;
use Illuminate\Support\Facades\Notification;
use App\Notifications\notifyMode;
use PHPUnit\Util\Json;
use App\Models\System_status;

class mqttController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pub(Request $request)
    {
        // return $request->all();
        // $status = "{'pump': " . $pump . ", 'mood': " . $mood . "}";
        $pump = $request->pump ? "true" : "false";
        $mode = $request->mode ? "true" : "false";

        MQTT::publish("smartfarm/command", '{"pump": "' . $pump . '", "operationMode": "' . $mode . '"}');

        System_status::create([
            "pump" => $request->pump,
            "mode" => $request->mode
        ]);

        Notification::route('mail', "mualiyuoox@gmail.com")->notify(new notifyAction("Water Pump", $pump, $mode));
    }

    public function pubMode(Request $request)
    {
        $pump = $request->pumpStatus ? "true" : "false";
        $mode = $request->modeStatus ? "true" : "false";


        MQTT::publish("smartfarm/command", '{"pump": "' . $pump . '", "operationMode": "' . $mode . '"}');

        System_status::create([
            "pump" => $request->pumpStatus,
            "mode" => $request->modeStatus
        ]);

        Notification::route('mail', "mualiyuoox@gmail.com")->notify(new notifyMode($pump, $mode));
    }
}
