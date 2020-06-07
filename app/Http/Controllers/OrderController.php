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
            $count = 0;
            foreach($order->book_orders as $book){
                if($order->books->find($book->book_id)){
                    $order->book_orders[$count]->deleted = false;
                }else {
                    $order->book_orders[$count]->deleted = true;
                }
                $count++;
            }
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
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
