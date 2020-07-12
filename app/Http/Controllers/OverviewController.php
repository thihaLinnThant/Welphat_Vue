<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

class OverviewController extends Controller
{
  private function add_meta_data($request)
  {
    return collect(['path' => $request->getPathInfo()]);
  }


  private function get_count($className){
    $nameSpace = '\\App\\'; 
    $model = $nameSpace . $className;
    $collections = $model::all();
    $overviews = collect();

    foreach ($collections as $overview) {
      $overview->created = Carbon::createFromFormat('Y-m-d H:i:s', $overview->created_at)
        ->format('d-m-Y');
      $overviews->push($overview);
    }

    $current = $newAdded = 0;

    foreach($overviews as $over){
      $over->created == Carbon::now()->format('d-m-Y') ? $newAdded++ : $current++;
    }

    return collect([
      'newAdded' => $newAdded,
      'current' => $current
    ]);

    //get_user_count
  }
  private function get_overview()
  {
    return collect([
      'booksCount' => $this->get_count('Book'),
      'usersCount' => $this->get_count('User')
    ]);
  }


  public function get_overview_api()
  {
    $data = $this->get_overview()->toArray();
    return response()->json($data);
  }

  public function get_overview_web(Request $request) {
    $data = $this->add_meta_data($request);
    return view('admin.app', ['data' => $data ]);
}
}
