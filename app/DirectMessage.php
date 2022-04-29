<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    protected $fillable = [
        'board_id', 'message', 'send_user', 'receive_user'
    ];

    public function board()
    {
        return $this->belongsTo('App\Board');
    }

}
