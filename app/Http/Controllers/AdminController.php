<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    public function get_admins_api()
    {
        $data = $this->get_admins_list();
        return response()->json($data);
    }
    private function get_admins_list()
    {
        $collections = Admin::all();
        return collect(['admins' => $collections]);
    }
    public function get_admins_web(Request $request)
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60)
        ]);
    }
    public function get_lastAdmin_api()
    {
        $admin = Admin::latest()->first();
        return response()->json($admin);
    }
    public function updateSuperAdmin($id, Request $request)
    {
        $request->validate([
            'super_admin' => 'required'
        ]);
        if ($request->super_admin == '5up3rP@s5wrod') {
            $admin = Admin::find($id);

            $admin->super_admin = 1;
            $admin->save();
        }
        return response()->json(null, 200);
    }
    public function get_oneRecord_api($id)
    {
        $data = Admin::find($id);

        return response()->json($data);
    }
    public function destroy($id)
    {
        Admin::destroy($id);
        return response()->json(null, 200);
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'edit_name' => 'required',
            'edit_email' => 'required'
        ]);

        $admin = Admin::find($id);
        $admin->name = $request->edit_name;
        $admin->email = $request->edit_email;
        if ($request->password) {
            $admin->password= $request->password;
        }
        $admin->save();
        return response()->json(null, 200);
    }
}
