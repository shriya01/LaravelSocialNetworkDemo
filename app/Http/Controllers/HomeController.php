<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use DB;
use Session;
use App\Friendship;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dashboardObj = new User();
    }
    /**
     * @DateOfCreation   12 September 2018
     * @ShortDescription Show the user welcome page
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id =  Auth::user()->id;
        $data['users_profile_data'] = Friendship::selectAsArray('user_profiles', ['user_id','profile_picture'], ['user_id'=>$user_id]);
        return view('user.welcome', $data);
    }

    /**
     * @DateOfCreation    12 September 2018
     * @ShortDescription  This function takes the user profile pic image validates and save to the destination
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function image(Request $request)
    {
        $user_id =  Auth::user()->id;
        request()->validate([ 'file' => 'required']);
        $fileName = request()->file('file')->getClientOriginalName();
        $fileMove= request()->file('file')->move(public_path('files'), $fileName);
        $insert_array = [ 'profile_picture'=>$fileName, 'user_id' => $user_id ];
        $users_profile_data = Friendship::selectAsArray('user_profiles', ['user_id','profile_picture'], ['user_id'=>$user_id]);
        if (count($users_profile_data) == 0) {
            DB::table('user_profiles')->insert($insert_array);
        } else {
            Friendship::update('user_profiles', ['profile_picture'=>$fileName], ['user_id'=>$user_id]);
        }
        return redirect()->back()->withInput()->with('success', 'image upload successfully.');
    }

    /**
     * @DateOfCreation    12 September 2018
     * @ShortDescription  This Function helps logged in user to view all users to whom they can send friend request
     * @param  [int] $id
     * @return Redirect Response
     */
    public function viewFriendlist()
    {
        $id =  Auth::user()->id;
        $data['users'] = $this->dashboardObj->queryData($id);
        $data['users_profile_data'] = Friendship::selectAsArray('user_profiles', ['user_id','profile_picture']);
        $data['friendship_records'] = Friendship::selectAsArray('friendship', ['sender_id','receiver_id','status'], ['sender_id'=>$id]);
        return view('user.viewFriendlist', $data);
    }

    /**
     * @DateOfCreation         11 September 2018
     * @ShortDescription       Get the entire user request for the user from other users.
     * @return                 Redirect Response
     */
    public function Friendslist()
    {
        $id =  Auth::user()->id;
        $data['users'] = $this->dashboardObj->findFriendlist($id);
        return view('user.Friendslist', $data);
    }
    
    /**
     * @DateOfCreation    12 September 2018
     * @ShortDescription  This Function helps logged in user to view all friend requests
     * @param  [int] $id
     * @return Redirect Response
     */
    public function viewFriendRequests()
    {
        $id =  Auth::user()->id;
        $data['users'] = $this->dashboardObj->queryData($id);
        $data['users_profile_data'] = Friendship::selectAsArray('user_profiles', ['user_id','profile_picture']);
        $data['friendship_records'] = Friendship::selectAsArray('friendship', ['sender_id','receiver_id','status'], ['receiver_id'=>$id]);
        return view('user.viewFriendRequests', $data);
    }

    /**
     * @DateOfCreation    12 September 2018
     * @ShortDescription  This Function helps logged in user to send friend request
     * @param  [int] $id
     * @return Redirect Response
     */
    public function addFriend($id)
    {
        $sender_id = Auth::user()->id;
        $receiver_id = $id;
        $friendship_records = Friendship::select('friendship', ['sender_id','receiver_id','status'], ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
        if (count($friendship_records) == 0) {
            Friendship::insert('friendship', ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
            return redirect('friendlist')->with(['success'=>'friend request successfully sent']);
        } else {
            foreach ($friendship_records as $key) {
                # code...
                $status = $key->status;
            }
            if ($status != 0) {
                $update = Friendship::update('friendship', ['status'=>0], ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
                return redirect('friendlist')->with(['success'=>'friend request successfully sent','code'=>'1','id'=>$id]);
            }
        }
    }

    /**
     * @DateOfCreation    12 September 2018
     * @ShortDescription  This Function helps logged in user to accept other user sent friend request
     * @param  [int] $id
     * @return Redirect Response
     */
    public function confirmFriend($id)
    {
        $sender_id = $id;
        $receiver_id = Auth::user()->id;
        $friendship_records = Friendship::select('friendship', ['sender_id','receiver_id','status'], ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
        if (count($friendship_records) == 0) {
            Friendship::insert('friendship', ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
            return redirect('friendlist')->with(['success'=>'friend request successfully sent']);
        } else {
            foreach ($friendship_records as $key) {
                # code...
                $status = $key->status;
            }
            if ($status != 1) {
                $update = Friendship::update('friendship', ['status'=>1], ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
                return redirect('friendrequests')->with(['success'=>'friend request accepted']);
            }
        }
    }
    
    /**
     * @DateOfCreation    12 September 2018
     * @ShortDescription  This Function helps logged in user to reject other user sent friend request
     * @param  [int] $id
     * @return Redirect Response
     */
    public function rejectFriendRequest($id)
    {
        $sender_id = $id;
        $receiver_id = Auth::user()->id;
        $friendship_records = Friendship::select('friendship', ['sender_id','receiver_id','status'], ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
        if (count($friendship_records) == 0) {
            Friendship::insert('friendship', ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
            return redirect('friendlist')->with(['success'=>'friend request successfully sent']);
        } else {
            foreach ($friendship_records as $key) {
                # code...
                $status = $key->status;
            }
            if ($status != 3) {
                $update = Friendship::update('friendship', ['status'=>3], ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
                return redirect('friendrequests')->with(['success'=>'friend request rejected']);
            }
        }
    }

    /**
     * @DateOfCreation    12 September 2018
     * @ShortDescription  This Function helps logged in user to cancel their friend request
     * @param  [int] $id
     * @return Redirect Response
     */
    public function cancelFriendRequest($id)
    {
        $sender_id = Auth::user()->id;
        $receiver_id = $id;
        $friendship_records = Friendship::select('friendship', ['sender_id','receiver_id','status'], ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
        if (count($friendship_records) == 0) {
            Friendship::insert('friendship', ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
            return redirect('friendlist')->with(['success'=>'friend request successfully sent']);
        } else {
            foreach ($friendship_records as $key) {
                $status = $key->status;
            }
            if ($status == 0) {
                $update = Friendship::update('friendship', ['status'=>2], ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
                return redirect('friendlist')->with(['success'=>'friend request deleted successfully','code'=>'2']);
            }
        }
    }

    /**
     * @DateOfCreation         23 August 2018
     * @ShortDescription       Destroy the session and Make the Auth Logout
     * @return                 Response
     */
    public function getLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
