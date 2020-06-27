<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }

    private function get_book_list() {
        $collection = Book::with('authors')->with('categories')->with('tags')->get();
        $books = collect();
        foreach($collection as $book) {    
            $book->rates = $book->averageRating();
            $book->thumb = asset('storage/images/books/'. $book->id . '/thumb_nail.png');
            $books->push($book);
        }
        return collect(['books' => $books]);
    }

    public function get_books_api(){
        $data = $this->get_book_list()->toArray();
        return response()->json($data);
    }

    public function get_books_web(Request $request) {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data ]);
    }

    public function register_web(Request $request) {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }
    public function get_oneRecord_api($id){
        $data = Book::with('authors')->with('comments')->find($id);
        $data->rates = $data->averageRating();


        foreach($data->comments as $key=>$comment){
            $data->comments[$key]->user_info = User::where('id', $comment['user_id'])->first();
        }

        for($i= 0 ;$i< count($data->authors);$i++){
            $data->authors[$i]->thumb = asset('storage/images/authors/' . $data->authors[$i]->id . '/image_1.png');  
        }
        $data->thumb = asset('storage/images/books/' . $data->id . '/image_1.png');
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
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
