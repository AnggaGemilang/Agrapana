<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonitoringMainDevice;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MonitoringMainDeviceController extends Controller
{
    public function store(Request $request)
    {
        return MonitoringMainDevice::create($request->all());
    }

    public function show($id)
    {
        $monitoringMainDevice = MonitoringMainDevice::where('field_id', $id)->paginate(5);
        return $monitoringMainDevice;
    }

    public function getChartData($id, $column, $type)
    {
        $monitoringMainDevice = [];
        if($type == "latest"){
            $monitoringMainDevice = MonitoringMainDevice::select($column, 'created_at')
                ->where('field_id', $id)
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        } else if($type == "hour"){
            $monitoringMainDevice = MonitoringMainDevice::select($column, DB::raw('HOUR(created_at)'))
                ->where('field_id', $id)
                ->groupBy(DB::raw('HOUR(created_at)'))
                ->paginate(5);
        } else {
            $monitoringMainDevice = MonitoringMainDevice::select($column, DB::raw('DAY(created_at)'))
                ->where('field_id', $id)
                ->groupBy(DB::raw('DAY(created_at)'))
                ->paginate(5);
        }
        return $monitoringMainDevice;
    }
}
