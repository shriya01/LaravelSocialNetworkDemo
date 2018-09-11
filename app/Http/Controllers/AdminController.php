<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Admin;
use Config;
use Hash;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
    * @DateOfCreation         06 sep 2018
    * @ShortDescription       Load the login view for admin
    * @return                 View
    */
    public function getLogin()
    {
        return view('admin.login');
    }
    
    /**
    * @DateOfCreation         06 sep 2018
    * @ShortDescription       Load the login view for admin
    * @return                 View
    */
    public function postLogin(Request $request)
    {
        $rules = array(
            'email' => 'required',
            'password' => 'required'
        );
        // set validation rules 
        $validator = Validator::make($request->all(), $rules);
        //if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            // Get our login input
            $inputData = array(
                'user_email' => $request->input('email'),
                'password' => $request->input('password')
            );
            //check auth
            if (Auth::attempt($inputData)) {
                $role_id =  Auth::user()->user_role_id;
                if ($role_id == Config::get('constants.ADMIN_ROLE')) {
                    return redirect("/dashboard")->with(array("message"=>__('messages.login_success')));
                } else {
                    return redirect()->back()->withInput()->withErrors(__('messages.account_not_exist'));
                }
            } else {
                //Check Email exist in the database or not
                if (Admin::where('user_email', '=', $inputData['user_email'])->first()) {
                    $validator->getMessageBag()->add('password', __('messages.wrong_password'));
                } else {
                    $validator->getMessageBag()->add('email', __('messages.account_not_exist'));
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
    }
}
