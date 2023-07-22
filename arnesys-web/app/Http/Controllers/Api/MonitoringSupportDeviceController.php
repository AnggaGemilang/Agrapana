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

    public function getByColumn($id, $number, $column)
    {
        return MonitoringSupportDevice::select($column)
            ->where('number_of', $number)
            ->where('field_id', $id)
            ->paginate(5);
    }

}
