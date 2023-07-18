<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonitoringMainDevice;
use Illuminate\Http\Request;

class MonitoringMainDeviceController extends Controller
{
    public function index()
    {
        return MonitoringMainDevice::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        return MonitoringMainDevice::create($request->all());
    }

    public function show($id)
    {
        $monitoringMainDevice = MonitoringMainDevice::where('field_id', $id)->paginate(5);
        return $monitoringMainDevice;
    }

    public function update(Request $request, MonitoringMainDevice $monitoringMainDevice)
    {
        $monitoringMainDevice->update($request->all());
        $monitoringMainDevice->refresh();
        return $monitoringMainDevice;
    }

    public function destroy(MonitoringMainDevice $monitoringMainDevice)
    {
        return $monitoringMainDevice->delete();
    }
}
