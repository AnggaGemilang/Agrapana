<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FieldController extends Controller
{

    function index(){
        return view('master.field.index');
    }

    function getByClient($id){
        return view('master.field.index');
    }

    function detail($id){
        return view('master.field.detail');
    }

}
