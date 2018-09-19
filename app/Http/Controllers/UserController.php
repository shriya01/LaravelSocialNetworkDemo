<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Auth;
use Config;

class UserController extends Controller
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
    * [addFriend description]
    * @param [type] $id [description]
    */
    public function addFriend($id)
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $recipient = Users::find($id);
        if (! $user->hasSentFriendRequestTo($recipient)) {
            $user->befriend($recipient);
            return redirect('friendSuggestionList')->with('success', 'friend request sent successfully');
        }
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
        if ($user->acceptFriendRequest($sender)) {
            return redirect('pendingrequests')->with('success', 'friend request accepted');
        }
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
        if ($user->denyFriendRequest($sender)) {
            return redirect('pendingrequests')->with('success', 'friend request rejected successfully');
        }
    }
    /**
    * [cancelFriendRequest description]
    * @param  [type] $id [description]
    * @return [type]     [description]
    */
    public function cancelFriendRequest($id)
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $recipient = Users::find($id);
        if ($user->hasSentFriendRequestTo($recipient)) {
            $recipient->denyFriendRequest($user);
            return redirect('friendSuggestionList')->with('success', 'friend request cancelled successfully');
        }
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
        $data['friends'] = $user->getFriends()->toArray();
        $data['count'] = count($user->getFriendRequests()->toArray());
        $data['friends_count'] = count($user->getAcceptedFriendships()->toArray());
        return view('user.FriendsList', $data);
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
        if ($user->blockFriend($friend)) {
            return redirect('friendlist')->with('success', 'friend blocked successfully');
        }
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
        $data['count'] = count($user->getFriendRequests()->toArray());
        $data['friends_count'] = count($user->getAcceptedFriendships()->toArray());
        $user_records= [];
        foreach ($data['pendingRequests'] as $key => $value) {
            $sender_id = $data['pendingRequests'][$key]['sender_id'];
            array_push($user_records, Users::find($sender_id)->toArray());
        }
        $data['user_records'] =$user_records;
        return view('user.pendingRequests', $data);
    }
    /**
    * [friendSuggestionList description]
    * @return [type] [description]
    */
    public function friendSuggestionList()
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $data['users'] = Users::get()->toArray();
        $data['count'] = count($user->getFriendRequests()->toArray());
        $data['friends_count'] = count($user->getAcceptedFriendships()->toArray());
        foreach ($data['users'] as $key => $value) {
            $recipient_id = $data['users'][$key]['id'];
            $recipient = Users::find($recipient_id);
            if ($user->hasSentFriendRequestTo($recipient)) {
                $data['users'][$key]["status"] = Config::get('constants.PENDING');
            } elseif ($user->isBlockedBy($recipient)) {
                $data['users'][$key]["status"] = Config::get('constants.BLOCKED');
            } elseif ($user->isFriendWith($recipient)) {
                $data['users'][$key]["status"] = Config::get('constants.ACCEPTED');
            } elseif ($user->hasFriendRequestFrom($recipient)) {
                $data['users'][$key]["status"] = Config::get('constants.INCOMING_PENDING');
            } else {
                $data['users'][$key]["status"] = Config::get('constants.NO_RELATION');
            }
        }
        return view('user.friendSuggestionList', $data);
    }
    /**
     * [removeFriend description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function removeFriend($id)
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $friend = Users::find($id);
        if ($user->unfriend($friend)) {
            return redirect('friendlist')->with('success', 'friend removed successfully');
        }
    }
}
