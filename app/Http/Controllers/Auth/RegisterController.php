<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use  Illuminate\Http\Request;
use Config;
use App\VerifyUser;
use Mail;
use App\Mail\VerifyMail;

/**
 * RegisterController Class
 * @category            Controller
 * @DateOfCreation      19 March 2018 04:00 PM
 * @ShortDescription    This class handles new user registrations
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * @DateOfCreation         14 September 2018
     * @ShortDescription  Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * @DateOfCreation         14 September 2018
     * @ShortDescription  Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * @DateOfCreation         14 September 2018
     * @ShortDescription       view user registration from
     * @return                 View
     */
    public function getRegister()
    {
        return view('user.register');
    }

    /**
     * @DateOfCreation         14 September 2018
     * @ShortDescription       Register user from user side
     * @return                 View
     */
    public function postRegister(Request $request)
    {
        $rules = array(
            'user_first_name' => 'required|max:50',
            'user_last_name'  => 'required|max:50',
            'user_email'      => 'required|string|email|max:255|unique:users',
            'password'        => 'required|string|min:6|confirmed'
            );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        } else {
            if (empty($id)) {
                $insertData = array(
                    'user_first_name' => $request->input('user_first_name'),
                    'user_last_name'  => $request->input('user_last_name'),
                    'user_email'      => $request->input('user_email'),
                    'password'        => bcrypt($request->input("password")),
                    'user_role_id'    => Config::get('constants.USER_ROLE')
                    );
                $user = User::create($insertData);
                $verifyUser = VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => str_random(40)
                    ]);

                Mail::to($user->user_email)->send(new VerifyMail($user));

                if ($response = $this->registered($request, $user)) {
                    return $response;
                }
            }
        }
    }
    /**
     * @DateOfCreation         14 September 2018
     * @ShortDescription       This function checks whether the user is verified or not
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/login')->with('status', $status);
    }
    /**
     * @DateOfCreation         14 September 2018
     * @ShortDescription       This function is used to tell user that they are registered but not
     *                         verified yet
     * @param  Request $request [description]
     * @param  [type]  $user    [description]
     * @return [type]           [description]
     */
    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/login')->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
    }
}
