<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\User;
use Config;
class DashboardController extends Controller
{
    
 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->adminobj = new Admin;
        $this->userobj  = new User;
    }
    /**
     * @DateOfCreation         23 August 2018
     * @ShortDescription       Load the dashboard view
     * @return                 View
     */
    public function index()
    {
        /**
         * @ShortDescription Blank array for the count for sending the array to the view.
         *
         * @var Array
         */
        $count = [];
        //display no of users that are of user type
        $count['users']  = $this->adminobj->countRecords(['user_role_id'=>Config::get('constants.USER_ROLE')]);
        //loads dashboard view with user number of records
        return view('admin.dashboard', compact('count'));
    }
        /**
     * @DateOfCreation         23 August 2018
     * @ShortDescription       Load users view with list of all users
     * @return                 View
     */
    public function users()
    {
        /**
         * @ShortDescription Blank array for the data for sending the array to the view.
         *
         * @var Array
         */
        $data = [];
        //get all user record whose user type is not admin
        $data['users'] = $this->adminobj->getRecordsWhereKeyIsNotInArray('user_role_id', [Config::get('constants.ADMIN_ROLE')]);
        //loads user list view with data
        return view('admin.users', $data);
    }
}
