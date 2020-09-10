<?php

namespace App\Http\Controllers;

use App\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Admin;
use App\Events\AdminNotificationEvent;
use Illuminate\Database\Eloquent\Collection;

class AdminNotificationController extends Controller
{
    
    public function get_extra_data($noti){
        switch($noti->committed_item_type){
            case 'App\Admin': $noti->item_link = '/admin/admins/'. $noti->committed_item_id;$noti->item_link_label = 'view admin';break;
            case 'App\Book': $noti->item_link = '/admin/books/'. $noti->committed_item_id;$noti->item_link_label = 'view book';break;
            case 'App\Tag': $noti->item_link = '/admin/tags/'. $noti->committed_item_id;$noti->item_link_label = 'view tag';break;
            case 'App\Category': $noti->item_link = '/admin/categories/'. $noti->committed_item_id;$noti->item_link_label = 'view category';break;
            case 'App\Publisher': $noti->item_link = '/admin/publishers/'. $noti->committed_item_id;$noti->item_link_label = 'view publisher';break;
            case 'App\Supplier': $noti->item_link = '/admin/suppliers/'. $noti->committed_item_id;$noti->item_link_label = 'view supplier';break;
            case 'App\Order': $noti->item_link = '/admin/orders/'. $noti->committed_item_id;$noti->item_link_label = 'view order';break;
        }
        
        if($noti->committer_type == 'App\Admin'){
            $noti->committer->type = 'admin';
            if($noti->committer->id == Auth::user()->id){
                $noti->committer->name = 'You';
            }
        }else {
            $noti->committer->type = 'user';
        }
        
        $seen_by = explode(',', $noti->seen_by);
        if(in_array(Auth::user()->id, $seen_by)){
            $noti->seen = true;
        }else {
            $noti->seen = false;
        }        
    }

    public function get_all_notifications_api(){
        $collection = AdminNotification::with('committer:id,name')
                        ->with('committed_item:id,name')
                        ->get();
        foreach($collection as $noti){
            $this->get_extra_data($noti);
        }
        return $collection;
    }
    
    public function get_latest_notifications_api(){
        $collection = AdminNotification::with('committer:id,name')
                        ->with('committed_item:id,name')
                        ->latest()->take(20)->get();
                     
        foreach($collection as $noti){
            $this->get_extra_data($noti);
        }
        return $collection;
    }
    
    private function add_meta_data($request) {
        return collect(['path' => $request->getPathInfo()]);
    }
    
    public function get_all_notifications_web(Request $request){
        $data = $this->add_meta_data($request);
        return view('admin.app', ['data' => $data]);
    }
    
    public function get_lastNotification_api(){
        $data = AdminNotification::with('committer:id,name')->latest()->first();
        $this->get_extra_data($data);
        return response()->json($data);
    }

    public function batch_mark_seen(Request $request){
        foreach($request->selected as $item ){
            $noti = AdminNotification::find($item['id']);
            $seen_by = $noti->seen_by;
            $noti->seen_by = $seen_by . (string)Auth::user()->id . ',';
            $noti->save();
        }

        return response()->json(null,200);
    }
    
    public function create(Request $request){
        
        $seen_by = (string)Auth::user()->id . ',';
        dd($request);
        $noti = AdminNotification::create([
            'noti_type' => $request->noti_type,
            'message'   => $request->message,
            'committer_id' => $request->committer_id,
            'committer_type' => $request->committer_type,
            'seen_by'   => $seen_by,
            'committed_item_id' => $request->committed_item_id, 
            'committed_item_type' => $request->committed_item_type,
        ]);
            
        event(new AdminNotificationEvent($noti));
            
        return response()->json();
    }
    
    public function mark_seen($id){
        $noti = AdminNotification::find($id);
        $seen_by = $noti->seen_by;
        $noti->seen_by = $seen_by . (string)Auth::user()->id . ',';
        $noti->save();
        
        return response()->json();
    }
}
    