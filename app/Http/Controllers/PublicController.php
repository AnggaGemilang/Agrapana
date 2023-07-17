<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Presence;

class PublicController extends Controller
{

    public function index() {
        return view('pages.home');
    }

    public function postPresence(Request $request){
        $validator = Validator::make($request->presenceData, [
            'full_name' => 'required',
            'school' => 'required',
            'opinion' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Tidak Lengkap!'
            ], 400);
        }

        try {
            $data = $request->presenceData;
            $folderPath = public_path('uploaded/');
            $image_parts = explode(";base64,", $data["signature"]);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = uniqid() . '.'.$image_type;
            file_put_contents($folderPath . $file, $image_base64);

            Presence::create(
                [
                    "full_name" => $data["full_name"],
                    "school" => $data["school"],
                    "opinion" => $data["opinion"],
                    "signature" => $file,
                ]
            );
        } catch (QueryException $ex){
            return response()->json([
                'status' => 'Failed',
                'message' => $ex->getMessage()
            ], 400);
        }
        return response()->json([
            'status' => 'Success',
            'message' => "Thank You For Your Answer"
        ]);
    }
}
