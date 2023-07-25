<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonitoringSupportDevice;
use Illuminate\Http\Request;

class MonitoringSupportDeviceController extends Controller
{
    public function store(Request $request)
    {
        return MonitoringSupportDevice::create($request->all());
    }

    public function show($id, $number)
    {
        $monitoringSupportDevice = MonitoringSupportDevice::where('field_id', $id)
            ->where('number_of', $number)
            ->paginate(5);
        return $monitoringSupportDevice;
    }

    public function getChartData($id, $number, $column, $type)
    {
        $monitoringSupportDevice = [];
        if($type == "latest"){
            dd($id);
            $monitoringSupportDevice = MonitoringSupportDevice::select($column)
            ->where('number_of', $number)
            ->where('field_id', $id)
            ->paginate(5);
        } else if($type == "hour"){
            $monitoringSupportDevice = MonitoringSupportDevice::select($column)
            ->where('number_of', $number)
            ->where('field_id', $id)
            ->paginate(5);
        } else {
            $monitoringSupportDevice = MonitoringSupportDevice::select($column)
            ->where('number_of', $number)
            ->where('field_id', $id)
            ->paginate(5);
        }
        return $monitoringSupportDevice;
    }

}
