<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index(Request $request) {
        if($request->session()->has('login')){
            $totalVisitor = Presence::all()->count();

            $totalCountry = Presence::select('nationality')
                ->groupBy('nationality')
                ->get();

            $graphByVisitor = Presence::select([
                    DB::raw('COUNT(id) AS count'),
                    DB::raw('DATE(created_at) AS date'),
                ])
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();

            $graphByCountry = Presence::select([
                    DB::raw('db_negara.nicename'),
                    DB::raw('COUNT(nationality) AS count'),
                ])
                ->join('db_negara', 'db_negara.id','=','db_presensi.nationality')
                ->groupBy('db_negara.nicename')
                ->get();

            return view('pages.admin.home', compact('totalVisitor', 'totalCountry', 'graphByVisitor', 'graphByCountry'));
		} else{
            return view('pages.auth.login');
		}
    }

    public function getManage() {
        $presence = Presence::join('db_negara','db_presensi.nationality','=','db_negara.id')
            ->select('db_presensi.*','db_negara.nicename')
            ->get();
        return view('pages.admin.manage', compact('presence'));
    }

    public function login(Request $request) {
        if($request->session()->has('login')){
            return redirect()->to('/admin');
		} else{
            return view('pages.auth.login');
		}
    }

    public function logoutPost(Request $request) {
        $request->session()->forget('login');
        return redirect()->to('/admin/login');
    }

    public function loginPost(Request $request) {
        if($request->username == "admin" && $request->password == "admin"){
            $request->session()->put('login', true);
            return redirect()->to('/admin');
        }
    }

}
