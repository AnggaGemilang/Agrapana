<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
{

    function index(){
        $fields = Field::where('field_id', Auth::user()->id)->get();
        return view('master.field.index', compact('fields'));
    }

    function getByClient($id){
        $fields = Field::where('client_id', $id)->get();
        return view('master.field.index', compact('fields'));
    }

    function detailMainDevice($id){
        $field = Field::findOrFail($id);
        return view('master.field.detail-main-device', compact('field'));
    }

    function detailSupportDevice($id, $number){
        $field = Field::findOrFail($id);
        return view('master.field.detail-support-device', compact('field'));
    }

    function store(Request $request){

        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'plant_type' => 'required',
            'number_of_support_device' => 'required'
        ]);

        if($validator->fails()) {
            Alert::error('Failed', 'Field datas not valid');
            return redirect()->back()->withErrors($validator);
        }

        $field = new Field();
        $field->address = $request->address;
        $field->plant_type = $request->plant_type;
        $field->client_id = $request->client_id;
        $field->number_of_support_device = $request->number_of_support_device;

        if($request->file('thumbnail') != null){
            $thumbnail = $request->file('thumbnail');
            $pathPhoto = $thumbnail->store('public/field/thumbnail');
            $field->thumbnail = $pathPhoto;
        }

        $field->save();

        Alert::success('Success', 'Field has been added');
        return redirect()->route('client');
    }

    function delete($id){
        $field = Field::findOrFail($id);
        $fieldId = $field->client_id;
        $field->delete();

        Alert::success('Success', 'Field has been deleted');
        return redirect()->route('client.field', $fieldId);
    }

}
