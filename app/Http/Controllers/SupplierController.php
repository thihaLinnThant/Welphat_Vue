<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private function get_suppliers() {
        $collection = Supplier::all([ 'id', 'name' ]);
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
        $data = Supplier::find($id);
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
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        
        Supplier::create([ 'name' => $request->name ]);

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
            'edit_name' => 'required'
        ]);
        
        $category = Supplier::find($id);
        $category->name = $request->edit_name;
        $category->save();

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
