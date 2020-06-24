<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private function get_orders() {
        $collection = Order::with('user')->with('book_orders')->get();

        $orders = collect();
        foreach($collection as $order){
            $order->total_price = $order->totalPrice();
            $order->count = $order->count();

            $orders->push($order);
        }

        return collect(['orders' => $orders]);
    }

    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }

    public function get_orders_api() {
        $data = $this->get_orders();
        return response()->json($data);
    }

    public function get_orders_web(Request $request) {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }

    public function get_lastorder_api() {
        $data = Order::latest()->first();
        return response()->json($data);
    }

    public function get_oneRecord_api($id){
        $data = Order::find($id);
        return response()->json($data);
    }

    public function updateStatus($id, Request $request){
        $order = Order::find($id);
        $order->status = $request->code;
        $order->save();
        return response()->json(null, 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {

        $order = Order::with('book_orders')->find($id);


        $order->user_name = $request->edit_name;
        $order->address = $request->edit_address;
        $order->phone_no = $request->edit_ph_no;
        $order->save();

        return response()->json(null, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::destroy($id);
        return response()->json(null, 200);
    }
}
