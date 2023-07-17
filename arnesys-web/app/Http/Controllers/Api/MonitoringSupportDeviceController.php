<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonitoringSupportDevice;
use Illuminate\Http\Request;

class MonitoringSupportDeviceController extends Controller
{

    public function index()
    {
        return MonitoringSupportDevice::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        return MonitoringSupportDevice::create($request->all());
    }

    public function show(MonitoringSupportDevice $monitoringSupportDevice)
    {
        return $monitoringSupportDevice;
    }

    public function update(Request $request, MonitoringSupportDevice $monitoringSupportDevice)
    {
        $monitoringSupportDevice->update($request->all());
        $monitoringSupportDevice->refresh();
        return $monitoringSupportDevice;
    }

    public function destroy(MonitoringSupportDevice $monitoringSupportDevice)
    {
        return $monitoringSupportDevice->delete();
    }
}
