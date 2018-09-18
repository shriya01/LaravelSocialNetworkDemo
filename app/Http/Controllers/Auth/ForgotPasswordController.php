<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use  Illuminate\Http\Request;
use Password;
use App\User;
use Mail;
use Illuminate\Mail\Message;

/**
 * ForgotPasswordController Class
 * @category            Controller
 * @DateOfCreation      19 March 2018 04:00 PM
 * @ShortDescription    This class handles how to send reset password link when user clicks forgot password
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * @DateOfCreation      18 Sept 2018
     * @ShortDescription  Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @DateOfCreation      18 Sept 2018
     * @ShortDescription    This function displays the form for requesting a link to reset password
     * @return View
     */
    public function showLinkRequestForm()
    {
        return view('user.email');
    }

    /**
     * @DateOfCreation      18 Sept 2018
     * @ShortDescription    Send a reset link to the given user.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $result =  $this->validateEmail($request);
        $response = $this->broker()->sendResetLink(
            $request->only('user_email')
        );
        $user = User::where('user_email', request()->input('user_email'))->first();
        $token = Password::getRepository()->create($user);
        if ($user) {
            Mail::send(['html' => 'emails.password'], ['token' => $token], function (Message $message) use ($user) {
                $message->subject('Reset Your Email Password');
                $message->to($user->user_email);
            });
        }
        return $response == Password::RESET_LINK_SENT
        ? $this->sendResetLinkResponse($response)
        : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * @DateOfCreation        18 Sept 2018
     * @ShortDescription      Validate the email for the given request.
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['user_email' => 'required|email']);
    }

    /**
     * @DateOfCreation        18 Sept 2018
     * @ShortDescription      Get the response for a failed password reset link.
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
                ->withInput($request->only('user_email'))
                ->withErrors(['user_email' => trans($response)]);
    }
}
