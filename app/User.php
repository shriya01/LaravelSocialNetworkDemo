<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Config;
use App\Notifications\ResetPassword as ResetPasswordNotification;

/**
 * User Class
 *
 * @package
 * @subpackage            User
 * @category              Model
 * @DateOfCreation        17 August 2018
 * @DateOfDeprecated
 * @ShortDescription      This class contains code that deals with users without admin access
 * @LongDescription
 */
class User extends Authenticatable
{
    use Notifiable;
    /**
     *@ShortDescription Table for the users.
     *
     * @var String
     */
    protected $table = 'users';
    protected $username = 'user_email';

  
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
    /**
     * @DateOfCreation         12 September 2018
     * @ShortDescription       Get the entire pending user request for the user from other users.
     * @param  int $id
     * @return  View
     */
    public function findFriendlist($id)
    {
        return  DB::table('friendship')
                ->join('users', 'friendship.sender_id', '=', 'users.id')
                ->select(array('users.id','friendship.receiver_id','users.user_first_name','users.user_last_name'))
                ->where('status', '=', Config::get('constants.ACCEPTED'))
                ->where('receiver_id', '=', $id)
                ->get();
    }
    /**
     * @DateOfCreation         07 Sep 2018
     * @ShortDescription       Load the dashboard view
     * @return                 View
     */
    public function queryData($id)
    {
        return User::where('user_role_id', '!=', Config::get('constants.ADMIN_ROLE'))->where('id', '!=', $id)->get()->toArray();
    }
    /**
     * [verifyUser description]
     * @return [type] [description]
     */
    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
    /**
     * [getEmailForPasswordReset description]
     * @return [type] [description]
     */
    public function getEmailForPasswordReset()
    {
        return $this->user_email;
    }
    /**
     * [sendPasswordResetNotification description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public  function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
