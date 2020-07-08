<?php

namespace App\Http\Controllers;

use App\User;
use App\Book_order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get_users_api()
    {
        $data = $this->get_users_list();
        return response()->json($data);
    }
    private function get_users_list()
    {

        $collection = User::with('wishes')->get();


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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        $hashed_password = Hash::make($request->password);
        User::create(['name' => $request->name, 'email' => $request->email, 'password' => $hashed_password, 'ph_no' => $request->ph_no, 'address' => $request->address]);
    }
    public function get_lastUser_api()
    {
        $data = User::latest()->first();
        return response()->json($data);
    }
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(null, 200);
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'edit_name' => 'required',
            'edit_email' => 'required',
            'edit_ph_no' => 'required',
            'edit_address' => 'required'
        ]);

        $user = User::find($id);
        $user->name = $request->edit_name;
        $user->email = $request->edit_email;
        $user->ph_no = $request->edit_ph_no;
        $user->address = $request->edit_address;

        $user->save();

        return response()->json(null, 200);
    }

    public function get_oneRecord_api($id)
    {
        $data = User::with('wishes')->with('comments')->with('orders')->find($id);
        $bookCount = 0;
        foreach ($data->orders as $key=>$order) {
            $collection = Book_order::where('order_id', $order->id)->get();
            $data->orders[$key]['books'] = $collection;
            $bookCount++;
        }
        $data->order_count = $bookCount;

        return response()->json($data);
    }
    public function singleView(Request $request)
    {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }
}
