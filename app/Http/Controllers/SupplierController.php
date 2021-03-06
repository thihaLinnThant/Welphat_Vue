<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private function get_suppliers() {
        $collection = Supplier::all([ 'id', 'name', 'phno', 'address', 'email' ]);
        $suppliers = collect();
        foreach($collection as $supplier) {
            $supplier->count = $supplier->books()->count();
            $suppliers->push($supplier);
        }
        return collect(['suppliers' => $suppliers]);
    }

    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }

    public function get_suppliers_api() {
        $data = $this->get_suppliers();
        return response()->json($data);
    }

    public function get_suppliers_web(Request $request) {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }

    public function get_lastSupplier_api() {
        $data = Supplier::latest()->first();        
        return response()->json($data);
    }

    public function get_oneRecord_api($id){
        $data = Supplier::with('books')->find($id);
        for($i= 0 ;$i< count($data->books);$i++){
            $data->books[$i]->thumb = asset('storage/images/books/' . $data->books[$i]->id . '/image_1.png');
        }
        return response()->json($data);
    }
    public function singleView(Request $request)
    {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
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
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'ph_no' => 'required',
            'address' => 'required',
            'email' => 'required'
        ]);
        
        Supplier::create([ 
            'name' => $request->name,
            'phno' => $request->ph_no,
            'address' => $request->address,
            'email' => $request->email
        ]);

        return response()->json(null,200);
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
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'edit_name' => 'required',
            'edit_ph_no' => 'required',
            'edit_address' => 'required',
            'edit_email' => 'required'
        ]);
        
        $supplier = Supplier::find($id);
        $supplier->name = $request->edit_name;
        $supplier->phno = $request->edit_ph_no;
        $supplier->address = $request->edit_address;
        $supplier->email = $request->edit_email;
        $supplier->save();

        return response()->json(null,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::destroy($id);
        return response()->json(null, 200);
    }
}
