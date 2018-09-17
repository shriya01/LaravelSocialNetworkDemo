<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    protected $guarded = [];
 	/**
 	 * [user description]
 	 * @return [type] [description]
 	 */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
