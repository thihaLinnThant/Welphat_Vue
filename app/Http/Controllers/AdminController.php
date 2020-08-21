<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


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
        foreach($collections as $admin){
            if(file_exists( public_path() . 'storage/images/admins/' . $admin->id . '/image_1.png')){
                $admin->thumb = asset('storage/images/admins/' . $admin->id . '/image_1.png');
            }
        }
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
            'password' => 'required',
        ]);

        if(!$request->super_admin){
            $request->super_admin = false;
        }

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'super_admin' => $request->super_admin,
            'api_token' => Str::random(60),
        ]);
        
        if(isset($request->image)){
            $lastid = Admin::latest()->first('id')->id;
            $file = file_get_contents($request->image);
            $path = '/images/admins/' . $lastid . "/image_1.png";
            Storage::disk('public')->put($path, $file);
        }

        return response()->json(null,200);
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
        Storage::deleteDirectory('/images/admins/'.$id);
        return response()->json(null, 200);
    }
}
