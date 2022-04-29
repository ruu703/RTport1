<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'project_id', 'order_user_id', 'apply_user_id'
    ];

    public function user()
    {
        // if($id = 0){
            return $this->belongsTo('App\User', 'id', 'apply_user_id');
        // }elseif($id = 1){
        //     return $this->belongsTo('App\User', 'id', 'apply_user_id');
        // }
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function directmessage()
    {
        return $this->hasMany('App\DirectMessage');
    }
}
