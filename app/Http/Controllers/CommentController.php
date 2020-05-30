<?php
namespace App\Http\Controllers;
use App\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{

    private function get_comments() {
        $collection = Comment::with('book')->with('user')->get();
        return collect(['comments' => $collection]);

    }

    public function get_comments_api(){
        $data = $this->get_comments();
        return response()->json($data);

    }

    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }

    public function get_comments_web(Request $request){
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }
}
