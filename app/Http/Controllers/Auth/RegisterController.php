<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\VerifyUser;
use App\Mail\VerifyMail;
use Mail;
use Illuminate\Http\Request;

/**
 * RegisterController Class
 * @category            Controller
 * @DateOfCreation      20 September 2018
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
     * @DateOfCreation      20 September 2018
     * @ShortDescription    Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * @DateOfCreation      20 September 2018
     * @ShortDescription    Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @DateOfCreation      20 September 2018
     * @ShortDescription    Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            ]);
    }

    /**
     * @DateOfCreation      20 September 2018
     * @ShortDescription    Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
            ]);

        Mail::to($user->email)->send(new VerifyMail($user));

        return $user;
    }

    /**
     * @DateOfCreation       20 September 2018
     * @ShortDescription     This function checks whether the user is verified or not
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
