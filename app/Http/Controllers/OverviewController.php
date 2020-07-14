<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Order;


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
  }
  private function get_overview()
  {
    return collect([
      'booksCount' => $this->get_count('Book'),
      'usersCount' => $this->get_count('User'),
      'income' => $this->get_income()
    ]);
  }
  private function get_income(){
    $orders = Order::with('book_orders')->get();
    $income = 0;
    foreach($orders as $order){
      foreach($order->book_orders as $bookOrder){
        $income += $bookOrder->book_price* $bookOrder->qty;

      }
    }
    return $income;
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
