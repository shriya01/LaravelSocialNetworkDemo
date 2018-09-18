<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use  Illuminate\Http\Request;
use Password;

/**
 * ResetPasswordController Class
 * @category            Controller
 * @DateOfCreation      19 March 2018 04:00 PM
 * @ShortDescription    This class handles reset requests
 */
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * @DateOfCreation      18 Sept 2018
     * @ShortDescription    Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * @DateOfCreation      18 Sept 2018
     * @ShortDescription   Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * @DateOfCreation      18 Sept 2018
     * @ShortDescription    This function show reset form
     * @param  Request $request [description]
     * @param  [type]  $token   [description]
     * @return [type]           [description]
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('emails.reset')->with(
              ['token' => $token, 'email' => $request->email]
         );
    }

    /**
     * @DateOfCreation      18 Sept 2018
     * @ShortDescription Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $result = $this->validate($request, $this->rules(), $this->validationErrorMessages());
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($response)
                    : $this->sendResetFailedResponse($request, $response);
    }
    /**
     * @DateOfCreation      18 Sept 2018
     * @ShortDescription Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'user_email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }
    /**
     * @DateOfCreation      18 Sept 2018
     * @ShortDescription    Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
                    ->withInput($request->only('user_email'))
                    ->withErrors(['user_email' => trans($response)]);
    }
}
