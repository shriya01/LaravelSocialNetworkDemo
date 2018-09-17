<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use  Illuminate\Http\Request;
use Validator;
use Auth;
use Config;
use App\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
    * @DateOfCreation         06 sep 2018
    * @ShortDescription       Load the login view for admi
    * @return                 View
    */
    public function getLogin()
    {
        return view('user.login');
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
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            $inputData = array(
                'user_email' => $request->input('email'),
                'password' => $request->input('password')
                );
            if (Auth::attempt($inputData)) {
                $role_id =  Auth::user()->user_role_id;
                $user = Auth::user();

               if($newroute = $this->authenticated($request,$user))
               {
                return $newroute;
                die;
               } 
                if ($role_id == Config::get('constants.USER_ROLE')) {
                    return redirect("/welcome")->with(array("message"=>__('messages.login_success')));
                } else {
                    return redirect()->back()->withInput()->withErrors(__('messages.account_not_exist'));
                }
            } else {
              if (User::where('user_email', '=', $inputData['user_email'])->first()) {
                    $validator->getMessageBag()->add('password', __('messages.wrong_password'));
                } else {
                    $validator->getMessageBag()->add('email', __('messages.account_not_exist'));
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
    }

    /**
    * [authenticated description]
    * @param  Request $request [description]
    * @param  [type]  $user    [description]
    * @return [type]           [description]
    */
    public function authenticated(Request $request, $user)
    {
        if (!$user->verified) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }
}
