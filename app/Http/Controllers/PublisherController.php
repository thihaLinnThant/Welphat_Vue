<?php

namespace App\Http\Controllers;

use App\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{

    private function get_publishers() {
        $collection = Publisher::all([ 'id', 'name' ]);
        $publishers = collect();
        foreach($collection as $publisher) {
            $publisher->count = $publisher->books()->count();
            $publishers->push($publisher);
        }
        return collect(['publishers' => $publishers]);
    }

    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }

    public function get_publishers_api() {
        $data = $this->get_publishers();
        return response()->json($data);
    }

    public function get_publishers_web(Request $request) {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }

    public function get_lastPublisher_api() {
        $data = Publisher::latest()->first();
        return response()->json($data);
    }

    public function get_oneRecord_api($id){
        $data = Publisher::with('books')->find($id);
        for($i= 0 ;$i< count($data->books);$i++){
            $data->books[$i]->thumb = asset('storage/images/books/' . $data->books[$i]->id . '/thumb_nail.png');
        }
        $data->thumb = asset('storage/images/books/' . $data->id . '/thumb_nail.png');
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
            'name' => 'required'
        ]);

        Publisher::create([ 'name' => $request->name ]);

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
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'edit_name' => 'required'
        ]);

        $category = Publisher::find($id);
        $category->name = $request->edit_name;
        $category->save();

        return response()->json(null,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Publisher::destroy($id);
        return response()->json(null, 200);
    }
}
