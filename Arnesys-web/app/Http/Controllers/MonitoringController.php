<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller {

    public function index(Request $request) {
        if($request->session()->has('login')){
            return view('pages.monitoring.home');
		} else{
            return redirect()->to('/auth/login');
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
        return redirect()->to('/auth/login');
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
