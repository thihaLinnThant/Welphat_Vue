<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\User;
use Carbon\Carbon;

class OverviewController extends Controller
{
  private function add_meta_data($request) {
      return collect(['path' => $request->getPathInfo()]);
  }
    private function get_overview(){
      $collections = Book::all();
      $overviews = collect();

      foreach($collections as $overview) {
        $current_date = substr(Carbon::now(),0,10);
        $overview->created_at = $current_date;
          $overviews->push($overview);
      }

      return collect([
          'allbooks' =>$overviews
      ]);
    }

    public function get_overview_api(){
      $data = $this->get_overview()->toArray();
      return response()->json($data);
    }

}
