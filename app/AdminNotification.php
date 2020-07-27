<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'message',
        'noti_type',
        'seen_by',
        'committer_id',
        'committer_type',
        'committed_item_id',
        'committed_item_type'
    ];

    public function committer(){
        return $this->morphTo();
    }

    public function committed_item(){
        return $this->morphTo();
    }
}
