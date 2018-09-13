<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
/**
 * Admin Class
 *
 * @package
 * @subpackage            User
 * @category              Model
 * @DateOfCreation        17 August 2018
 * @DateOfDeprecated
 * @ShortDescription      This class contains code that deals with users with admin access
 * @LongDescription
 */
class Admin extends Model
{
    use Notifiable;
    
    /**
     *@ShortDescription Table for the users.
     *
     * @var String
     */
    protected $table = 'users';

    /**
     *@ShortDescription  The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_first_name','user_last_name','user_role_id','user_status','user_email', 'password','user_created_at',
    ];
    /**
     *@ShortDescription The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password','remember_token',
    ];
     /**
     * @DateOfCreation         23-August-2018
     * @ShortDescription       This function count records and filter according to the condition passed in where array
     * @param  [array] $whereArray [conditions to be passed into where to filter records]
     * @return this function return the no of records
     */
    public function countRecords($whereArray)
    {
        return Admin::where($whereArray)->count();
    }
    /**
     * @DateOfCreation         23-August-2018
     * @ShortDescription       This function get records where specified key not belongs to the specified array
     * @param  [key] $whereNotInArrayKey [key to match]
     * @param  [array] $whereNotInArray    [array in which we match key not exist]
     * @return [total records which satisfy the condition]
     */
    public function getRecordsWhereKeyIsNotInArray($whereNotInArrayKey, $whereNotInArray)
    {
        return Admin::whereNotIn($whereNotInArrayKey, $whereNotInArray)->get();
    }
}
