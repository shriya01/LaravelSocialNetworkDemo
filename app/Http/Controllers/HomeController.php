<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Auth;

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
        return view('home');
    }

    /**
     * [addFriend description]
     * @param [type] $id [description]
     */
    public function addFriend($id)
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $recipient = Users::find($id);
        $user->befriend($recipient);
    }

    /**
     * [confirmFriendRequest description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function confirmFriendRequest($id)
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $sender = Users::find($id);
        $user->acceptFriendRequest($sender);
    }

    /**
     * [confirmFriendRequest description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function rejectFriendRequest($id)
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $sender = Users::find($id);
        $user->denyFriendRequest($sender);
    }

    /**
     * [getFriendList description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getFriendList()
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $friends = $user->getFriends()->toArray();
        foreach ($friends as $key => $value) {
            # code...
            echo $friends[$key]['email'];
        }
    }
    /**
     * [blockUser description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function blockUser($id)
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $friend = Users::find($id);
        $user->blockFriend($friend);
    }
    /**
     * [unblockUser description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function unblockUser($id)
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $friend = Users::find($id);
        $user->unblockFriend($friend);
    }
    /**
     * [showPendingRequests description]
     * @return [type] [description]
     */
    public function showPendingRequests()
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $data['pendingRequests'] = $user->getPendingFriendships()->toArray();
        $user_records= [];
        foreach ($data['pendingRequests'] as $key => $value) {
            $sender_id = $data['pendingRequests'][$key]['sender_id'];
            array_push($user_records, Users::find($sender_id)->toArray());
        }
        $data['user_records'] =$user_records;
        return view('user.pendingRequests', $data);
    }
}
