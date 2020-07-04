<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class TagController extends Controller
{

    private function get_tags() {
        $collection = Tag::all([ 'id', 'name' ]);
        $tags = collect();
        foreach($collection as $tag) {
            $tag->count = $tag->books()->count();
            $tags->push($tag);
        }
        return collect(['tags' => $tags]);
    }

    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }

    public function get_tags_api() {
        $data = $this->get_tags();
        return response()->json($data);
    }

    public function get_tags_web(Request $request) {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }

    public function get_lastTag_api() {
        $data = Tag::latest()->first();
        return response()->json($data);
    }

    public function get_oneRecord_api($id){
        $data = Tag::with('books')->find($id);
        for($i= 0 ;$i< count($data->books);$i++){
            $data->books[$i]->thumb = asset('storage/images/books/' . $data->books[$i]->id . '/image_1.png');
        }
        $data->thumb = asset('storage/images/authors/' . $data->id . '/image_1.png');
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

        Tag::create([ 'name' => $request->name ]);

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
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'edit_name' => 'required'
        ]);

        $category = Tag::find($id);
        $category->name = $request->edit_name;
        $category->save();

        return response()->json(null,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::destroy($id);
        return response()->json(null, 200);
    }
}
