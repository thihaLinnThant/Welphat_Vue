<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class AdminController extends Controller
{
    public function get_admins_api(){
        $data = $this->get_admins_list();
        return response()->json($data);
    }
    private function get_admins_list(){
        $collections = Admin::all();
        return collect(['admins' => $collections]);
    }
    public function get_admins_web(Request $request){
        $data = $this->add_meta_data($request);
        return view('admin.app', [ 'data' => $data ]);
    }
    private function add_meta_data($request){
        return collect(['path' => $request->getPathInfo()]);
    }
}
