<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return Client::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        return Client::create($request->all());
    }

    public function show(Client $client)
    {
        return $client;
    }

    public function update(Request $request, Client $client)
    {
        $client->update($request->all());
        $client->refresh();
        return $client;
    }

    public function destroy(Client $client)
    {
        return $client->delete();
    }
}
