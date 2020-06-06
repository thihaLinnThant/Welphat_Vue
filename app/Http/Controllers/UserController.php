<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get_users_api()
    {
        $data = $this->get_users_list();
        return response()->json($data);
    }
    private function get_users_list()
    {
        $collection = User::all();
        return collect(['users' => $collection]);
    }
    public function get_users_web(Request $request)
    {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }
    private function add_meta_data($request)
    {
        return collect(['path' => $request->getPathInfo()]);
    }
    public function create(Request $request)
    {
        User::create(['name' => $request->name]);
        return response()->json(null, 200);
    }
    public function get_lastUser_api(){
        $data = User::latest()->first();
        return response()->json($data);
    }
}
