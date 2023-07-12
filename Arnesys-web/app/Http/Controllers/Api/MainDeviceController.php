<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MainDevice;
use Illuminate\Http\Request;

class MainDeviceController extends Controller
{
    public function index()
    {
        return MainDevice::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        return MainDevice::create($request->all());
    }

    public function show(MainDevice $mainDevice)
    {
        return $mainDevice;
    }

    public function update(Request $request, MainDevice $mainDevice)
    {
        $mainDevice->update($request->all());
        $mainDevice->refresh();
        return $mainDevice;
    }

    public function destroy(MainDevice $mainDevice)
    {
        return $mainDevice->delete();
    }
}
