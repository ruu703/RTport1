<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'category_id', 'fee_low', 'fee_high', 'detail', 'order_user_id',
     'received_user_id', 'close_flg', 'delete_flg'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'category_id');
    }
}
