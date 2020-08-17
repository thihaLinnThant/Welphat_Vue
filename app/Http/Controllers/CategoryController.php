<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //Temporary -----------------------------------------
    public function get_home_web(Request $request) {
        $data = collect([
                'path' => $request->getPathInfo()
            ]);
        return view('admin.app', ['data' => $data]);
    }
    // --------------------------------------------------

    private function get_categories() {
        $collection = Category::all([ 'id', 'name' ]);
        $categories = collect();
        foreach($collection as $category) {
            $category->count = $category->books()->count();
            $categories->push($category);
        }
        return collect(['categories' => $categories]);
    }

    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }

    public function get_categories_api() {
        $data = $this->get_categories();
        return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
    }

    public function get_lastCategory_api() {
        $data = Category::latest()->first();
        return response()->json($data);
    }

    public function get_oneRecord_api($id){
        $data = Category::with('books')->find($id);
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

    public function get_categories_web(Request $request) {
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }
    /**
     * Display a listing of the resource.
     *e
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
                
        Category::create([ 'name' => $request->name ]);

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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'edit_name' => 'required'
        ]);

        $category = Category::find($id);
        $category->name = $request->edit_name;
        $category->save();

        return response()->json(null,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return response()->json(null, 200);
    }
}
