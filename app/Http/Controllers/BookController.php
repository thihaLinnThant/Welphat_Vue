<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use App\Tag;
use App\Author;
use App\Comment;
use App\Wish;
use App\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }
    private function get_book_list() {
        $collection = Book::with('authors')->with('categories')->with('tags')->with('publisher')->with('suppliers')->paginate(10);
        $books = collect();
        foreach($collection as $book) {
            $book->rates = $book->averageRating();
            $book->thumb = asset('storage/images/books/'. $book->id . '/thumb_nail.png');
            $books->push($book);
        }
        return collect([
            'books' => $books,
            'total_pages' => $collection->lastPage(),
            'current_page' => $collection->currentPage()
        ]);
    }
    
    public function get_books_api(){
        $data = $this->get_book_list()->toArray();
        return response()->json($data);
        // return Book::with('authors')->with('categories')->with('tags')->paginate(5);
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
        $data = Book::with('authors')->with('comments')->with('orders')->with('tags')->with('categories')->with('publisher')->with('suppliers')->findOrFail($id);
        $data->rates = $data->averageRating();
        
        
        foreach($data->comments as $key=>$comment){
            $data->comments[$key]->user_info = User::where('id', $comment['user_id'])->first();
        }
        
        for($i= 0 ;$i< count($data->authors);$i++){
            $data->authors[$i]->thumb = asset('storage/images/authors/' . $data->authors[$i]->id . '/image_1.png');
        }
        $data->thumb = asset('storage/images/books/' . $data->id . '/thumb_nail.png');
        
        //get wish list count
        $data->wish_count = count(Wish::where('book_id', $id)->get());
        return $data? response()->json($data) : response()->json('not found',404); 
        
    }
    public function singleView(Request $request)
    {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
        
        foreach($data->comments as $key=>$comment){
            $data->comments[$key]->user_info = User::where('id', $comment['user_id'])->first();
        }
        
        for($i= 0 ;$i< count($data->authors);$i++){
            $data->authors[$i]->thumb = asset('storage/images/authors/' . $data->authors[$i]->id . '/image_1.png');
        }
        $data->thumb = asset('storage/images/books/' . $data->id . '/image_1.png');
        return response()->json($data);
    }
    
    public function get_lastBook_api(){
        $data = Book::latest()->first();
        return response()->json($data);
    }
    
    public function book_search($value = "") {
        $collection = Book::where('name',"LIKE","%{$value}%")->with('authors')->with('categories')->with('tags')->with('publisher')->with('suppliers')->get();
        $books = collect();
        foreach($collection as $book) {
            $book->rates = $book->averageRating();
            $book->thumb = asset('storage/images/books/'. $book->id . '/thumb_nail.png');
            $books->push($book);
        }
        return collect([
            'books' => $books,
            'total_pages' => 0,
            'current_page' => 0
        ]);
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(Request $request){
        $tags = Tag::all();
        $author = Author::all();
        $request->validate([
            'book_name' => 'required',
            'book_description'  => 'required',
            'book_price' => 'required',
            'publisher' => 'required',
            'book_published_date' => 'required'
        ]);
        $book = Book::create([
            'name' => $request->book_name,
            'description' => $request->book_description,
            'price' => $request->book_price,
            'publisher_id' => $request->publisher,
            'published_date' => $request->book_published_date
        ]);
        $lastid = Book::latest()->first('id')->id;
        
        $file = file_get_contents($request->image);
        $path = '/images/books/' . $lastid . "/thumb_nail.png";
        Storage::disk('public')->put($path, $file);
        
        $book->tags()->sync($request->tags);
        $book->authors()->sync($request->authors);
        $book->categories()->sync($request->categories);
        $book->suppliers()->sync($request->supplier);
        
        return response()->json("successfully created", 200);
        
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
    * @param  \App\Book  $book
    * @return \Illuminate\Http\Response
    */
    public function view_edit(Request $request,$id)
    {
        $data = $this->add_meta_data($request);
        $book = Book::with('authors')->with('tags')->with('categories')->with('publisher')->with('suppliers')->find($id);
        
        return view('admin.app', ['data' => $data, 'book' => $book]);
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Book  $book
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $book->authors()->sync($request->edit_authors);
        $book->tags()->sync($request->edit_tags);
        $book->suppliers()->sync($request->edit_suppliers);
        $book->categories()->sync($request->edit_categories);
        $book->publisher_id = $request->edit_publisher;
        
        $book->name = $request->edit_name;
        $book->price = $request->edit_book_price;
        $book->description = $request->edit_book_description;
        $book->published_date = $request->edit_book_published_date;
        
        $file = file_get_contents($request->edit_image);

        

        $path = '/images/books/' . $id . "/thumb_nail.png";
        Storage::disk('public')->put($path, $file);
        
        $book->save();
        return response()->json(null, 200);
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Book  $book
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $book = Book::find($id);
        $comment = Comment::where('book_id',$id);
        $comment->delete();
        $book->delete();
        Storage::deleteDirectory('/images/books/'.$id);
        return response()->json('successfully deleted', 200);
        
    }
}
