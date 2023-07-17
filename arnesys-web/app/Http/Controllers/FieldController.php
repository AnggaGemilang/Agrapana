<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FieldController extends Controller
{

    function index(){
        $fields = Field::where('client_id', Auth::user()->id)->get();
        return view('master.field.index', compact('fields'));
    }

    function getByClient($id){
        $fields = Field::where('client_id', $id)->get();
        return view('master.field.index', compact('fields'));
    }

    function detailMainDevice($id){
        return view('master.field.detail-main-device');
    }

    function detailSupportDevice($id, $number){
        return view('master.field.detail-support-device');
    }

}
