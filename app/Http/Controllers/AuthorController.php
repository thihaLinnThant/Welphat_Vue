<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }

    private function get_authors() {
        $collection = Author::all([ 'id', 'name' ]);
        $authors = collect();
        foreach($collection as $author) {
            $author->thumb = asset('storage/images/books/'. $author->id . '/thumb_nail.png');
            $author->count = $author->books()->count();
            $authors->push($author);
        }        
        return collect(['authors' => $authors]);
    }

    public function get_authors_api() {
        $data = $this->get_authors();
        return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
    }

    public function get_lastAuthor_api() {
        $data = Author::latest()->first();
        $data->thumb = asset('storage/images/books/'. $data->id . '/thumb_nail.png');
        $data->count = $data->books()->count();
        return response()->json($data);
    }

    public function get_authors_web(Request $request) {
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        Author::create(['name' => $request->name]);

        // $lastid = Author::latest()->first(['id']);
        // $file = file_get_contents($request->image);
        // $path = '/images/books/' . $lastid . "/image_1.png";
        // Storage::disk('public')->put($path , $file);

        // $thumb_file = file_get_contents('https://dummyimage.com/150x200/4053b5/f0e8f0');
        // $thumb_path = '/images/books/' . $lastid . '/thumb_nail.png';
        // Storage::disk('public')->put($thumb_path , $thumb_file);


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
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        //
    }
}
