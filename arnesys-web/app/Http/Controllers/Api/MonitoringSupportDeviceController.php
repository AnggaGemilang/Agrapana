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
}
