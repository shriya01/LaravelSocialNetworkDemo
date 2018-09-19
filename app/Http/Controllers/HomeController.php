<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Users;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $data['count'] = count($user->getFriendRequests()->toArray());
                        $data['friends_count'] = count($user->getAcceptedFriendships()->toArray());

        return view('home', $data);
    }
}
