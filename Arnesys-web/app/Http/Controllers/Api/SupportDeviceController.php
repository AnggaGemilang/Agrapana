<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportDevice;
use Illuminate\Http\Request;

class SupportDeviceController extends Controller
{

    public function index()
    {
        return SupportDevice::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        return SupportDevice::create($request->all());
    }

    public function show(SupportDevice $supportDevice)
    {
        return $supportDevice;
    }

    public function update(Request $request, SupportDevice $supportDevice)
    {
        $supportDevice->update($request->all());
        $supportDevice->refresh();
        return $supportDevice;
    }

    public function destroy(SupportDevice $supportDevice)
    {
        return $supportDevice->delete();
    }
}
