<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Config;
class User extends Authenticatable
{
    use Notifiable;
    /**
     *@ShortDescription Table for the users.
     *
     * @var String
     */
    protected $table = 'users';

     /**
    * @DateOfCreation         07 Sep 2018
    * @ShortDescription       Load the dashboard view 
    * @return                 View
    */
    public function queryData($id){

        DB::enableQueryLog();

$user =DB::table('users')
            ->leftJoin('friendship', 'users.id', '=', 'friendship.receiver_id')
            ->select('user_first_name','users.id','receiver_id','sender_id','user_last_name','status')->where('users.id','!=',$id)->where('user_role_id','!=',1)->groupBy('receiver_id')
            ->get();

$query = DB::getQueryLog();

return $user;   }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_first_name','user_last_name','user_role_id','user_status','user_email', 'password','user_created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password','remember_token',
    ];
}
