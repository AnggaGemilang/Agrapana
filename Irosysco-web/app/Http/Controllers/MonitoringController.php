<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class MonitoringController extends Controller {

    protected $database;

    public function __construct() {
        $factory = (new Factory)
            ->withServiceAccount(__DIR__ . '/irosysco-firebase-adminsdk-p082c-e507f26294.json')
            ->withDatabaseUri('https://irosysco-default-rtdb.firebaseio.com');
        $this->database = $factory->createDatabase();
    }

    public function plants(){
        $ref = $this->database->getReference('plants')->orderByChild('category')->equalTo("Vegetable")->getValue();
        $refFailPlanted = $this->database->getReference('plants')->orderByChild('status')->equalTo("Failed")->getValue();
        $refSuccessPlanted = $this->database->getReference('plants')->orderByChild('status')->equalTo("Done")->getValue();
        return view('pages.monitoring.plantlist', compact('ref', 'refFailPlanted', 'refSuccessPlanted'));
    }

    public function presets(){
        $ref = $this->database->getReference('presets')->getValue();
        return view('pages.monitoring.preset', compact('ref'));
    }

    public function presetByType(Request $request) {
        $ref = $this->database->getReference('presets')->orderByChild('category')->equalTo($request->category)->getValue();
        if(count($ref) > 0){
            return response()->json($ref);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Data Tidak Ditemukan!'
            ], 400);
        }
    }

    public function plantByType(Request $request) {
        $ref = $this->database->getReference('plants')->orderByChild('category')->equalTo($request->category)->getValue();
        if(count($ref) > 0){
            return response()->json($ref);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Data Tidak Ditemukan!'
            ], 400);
        }
    }

    public function index(Request $request) {
        if($request->session()->has('login')){
            return view('pages.monitoring.home');
		} else{
            return redirect()->to('/monitoring/login');
		}
    }

    public function login(Request $request) {
        if($request->session()->has('login')){
            return redirect()->to('/monitoring');
		} else{
            return view('pages.auth.login');
		}
    }

    public function logoutPost(Request $request) {
        $request->session()->forget('login');
        return redirect()->to('/monitoring/login');
    }

    public function loginPost(Request $request) {
        if($request->username == "admin" && $request->password == "admin"){
            $request->session()->put('login', true);
            return redirect()->to('/monitoring');
        } else {
            return redirect()->to('/monitoring/login');
        }
    }
}
