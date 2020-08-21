<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    private function add_meta_data($request)
    {
        return collect(['path' => $request->getPathInfo()]);
    }

    private function get_authors()
    {
        $collection = Author::with('books')->get();
        $authors = collect();
        foreach ($collection as $author) {
            $author->thumb = asset('storage/images/authors/' . $author->id . '/image_1.png');
            $author->count = $author->books()->count();
            $author->books = $author->books();
            $authors->push($author);
        }
        return collect(['authors' => $authors]);
    }

    public function get_authors_api()
    {
        $data = $this->get_authors()->toArray();
        return response()->json($data);

        // return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
    }

    public function get_lastAuthor_api()
    {
        $data = Author::latest()->first();
        $data->thumb = asset('storage/images/authors/' . $data->id . '/image_1.png');
        $data->count = $data->books()->count();
        return response()->json($data);
    }

    public function get_authors_web(Request $request)
    {
        $data = $this->add_meta_data($request);

        return view('admin.app', ['data' => $data]);
    }

    public function get_oneRecord_api($id)
    {
        $data = Author::with('books')->find($id);
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
            'name' => 'required',
            'bio'  => 'required',
            'image' => 'required'
        ]);

        Author::create([
            'name' => $request->name,
            'bio'  => $request->bio
        ]);

        $lastid = Author::latest()->first('id')->id;

        $file = file_get_contents($request->image);
        $path = '/images/authors/' . $lastid . "/image_1.png";
        Storage::disk('public')->put($path, $file);

        // $thumb_file = file_get_contents($request->image);
        // $thumb_path = '/images/books/' . $lastid . '/thumb_nail.png';
        // Storage::disk('public')->put($thumb_path , $thumb_file);

        return response()->json(null, 200);
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
    public function update($id, Request $request)
    {
        $request->validate([
            'edit_name' => 'required',
            'edit_bio' => 'required'
        ]);
        $author = Author::find($id);
        $author->name = $request->edit_name;
        $author->bio = $request->edit_bio;

        $file = file_get_contents($request->edit_image);
        $path = '/images/authors/' . $id . "/image_1.png";
        Storage::disk('public')->put($path, $file);

        $author->save();
        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Author::destroy($id);
        Storage::deleteDirectory('/images/authors/'.$id);
        return response()->json(null, 200);
    }
}
