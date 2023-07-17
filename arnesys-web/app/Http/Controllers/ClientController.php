<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    function index(){
        $clients = DB::table('clients')
            ->join('fields', 'fields.client_id', '=', 'clients.id')
            ->select('clients.id', 'clients.name', 'clients.photo', 'clients.email', 'clients.created_at', 'clients.password', DB::raw("count(fields.id) as number_of_fields"))
            ->groupBy('clients.id', 'clients.name', 'clients.photo', 'clients.email', 'clients.created_at', 'clients.password')
            ->get();

        return view('master.client.index', compact('clients'));
    }

    function create(){
        return view('master.client.create');
    }

    function store(){

    }

}
