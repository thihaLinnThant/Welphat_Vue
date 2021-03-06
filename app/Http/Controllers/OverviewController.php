<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Order;
use App\Book;
use App\Wish;


class OverviewController extends Controller
{
  private function add_meta_data($request)
  {
    return collect(['path' => $request->getPathInfo()]);
  }


  private function get_count($className)
  {
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

    foreach ($overviews as $over) {
      $over->created == Carbon::now()->format('d-m-Y') ? $newAdded++ : $current++;
    }



    return collect([
      'newAdded' => $newAdded,
      'current' => $current + $newAdded,
      'lastMonth' => count($this->get_last_month_data($model)),
      'lastSevenDays' => count($this->getDaysRecord(7, $model)),
      'last30Days' => count($this->getDaysRecord(30, $model))
    ]);
  }
      // get last month data
  private function get_last_month_data($model, $pivot_table = null)
  {
    $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
    $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
    return $pivot_table ? $model::with($pivot_table)->whereBetween('created_at', [$fromDate, $tillDate])->get() : $model::whereBetween('created_at', [$fromDate, $tillDate])->get();
  }

  private function getDaysRecord($subDaysCount, $modelName, $pivot_table = null)
  {
    $date = Carbon::today()->subDays($subDaysCount);
    return $pivot_table? $modelName::with($pivot_table)->where('created_at', '>=', $date)->get() : $modelName::where('created_at', '>=', $date)->get();
  }
  private function get_overview()
  {
    return collect([
      'bookCount' => $this->get_count('Book'),
      'userCount' => $this->get_count('User'),
      'orderCount' => $this->get_count('Order'),
      'orderStatus' => $this->get_orders_count(),
      'bestSelling' => $this->get_best_selling_books(),
      'mostWish' => $this->get_most_wish_books(),
      'income' => $this->get_income()
    ]);
  }
  private function get_income()
  {
    $orders = Order::with('book_orders')->get();
    $incomeAll = 0;
    $incomeTdy = 0;
    $incomeLastMonth = 0;


    foreach ($orders as $order) {
      foreach ($order->book_orders as $bookOrder) {
        $bookOrder->created = Carbon::createFromFormat('Y-m-d H:i:s', $bookOrder->created_at)
          ->format('d-m-Y');
        
        $bookOrder->created == Carbon::now()->format('d-m-Y') ? $incomeTdy += $bookOrder->book_price * $bookOrder->qty : $incomeAll += $bookOrder->book_price * $bookOrder->qty++;
      }
    }

    foreach($this->get_last_month_data('\App\Order', 'book_orders') as $orderLastMonth){
      foreach($orderLastMonth->book_orders as $order){
        $incomeLastMonth += $order->book_price;

      }
    }

    return collect([
      'incomeAll' => $incomeAll,
      'incomeTdy' => $incomeTdy,
      'incomeLastMonth' => $incomeLastMonth,
      'incomeLast7Days' => $this->incomeByDay(7),
      'incomeLast30Days' => $this->incomeByDay(30)
    ]);
  }


  private function incomeByDay($day){
    $incomeLastDays = 0;

    foreach($this->getDaysRecord($day,'\App\Order','book_orders') as $orderDayRecords){
      foreach($orderDayRecords->book_orders as $orderDayRecord){
        $incomeLastDays += $orderDayRecord->book_price;
      }
    }
    return $incomeLastDays;
  }
  private function get_orders_count()
  {
    $orders = Order::all();
    $in_progress = $delivered = $canceled = $dued_pass = 0;
    foreach ($orders as $order) {
      switch ($order->status) {
        case 'code-3(in_progress)':
          $in_progress++;
          break;
        case 'code-2(canceled)':
          $canceled++;
          break;
        case 'code-1(delivered)':
          $delivered++;
          break;
        case 'code-4(passed_due)':
          $dued_pass++;
          break;
      }
    }
    return collect([
      'inProgress' => $in_progress,
      'delivered' => $delivered,
      'canceled' => $canceled,
      'dued' => $dued_pass
    ]);
  }

  private function get_best_selling_books()
  {
    $orders = Order::with('book_orders')->get();
    $bookBest = [];
    foreach ($orders as $order) {
      foreach ($order->book_orders as $book_order) {
        if ($book_order->book_id) {
          array_push($bookBest, $book_order->book_id);
        }
      }
    }
    $populars = $this->get_top_elements_from_array($bookBest);
    $best_selling_books = collect();
    foreach ($populars as $popular) {
      $books = Book::where('id', $popular)->first();
      $best_selling_books->push($books);
    }
    return $best_selling_books;
  }

  private function get_most_wish_books()
  {
    $wishes = Wish::all();
    $most_wish = [];
    foreach ($wishes as $wish) {
      if ($wish->book_id) {
        array_push($most_wish, $wish->book_id);
      }
    }
    $populars = $this->get_top_elements_from_array($most_wish);
    $most_wish_books = collect();
    foreach ($populars as $popular) {
      $books = $wishes->where('book_id', $popular)->first();
      $most_wish_books->push($books);
    }
    return $most_wish_books;
  }

  private function get_top_elements_from_array($payload_array)
  {
    $values = array_count_values($payload_array);
    arsort($values);
    $populars = array_slice(array_keys($values), 0, 10, true);
    return $populars;
  }


  public function get_overview_api()
  {
    $data = $this->get_overview()->toArray();
    return response()->json($data);
  }

  public function get_overview_web(Request $request)
  {
    $data = $this->add_meta_data($request);
    return view('admin.app', ['data' => $data]);
  }
}
