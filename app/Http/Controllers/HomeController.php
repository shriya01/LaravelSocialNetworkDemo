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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id =  Auth::user()->id;
        return view('user.welcome');
    }
    /**
     * [image description]
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
        DB::table('user_profiles')->insert($insert_array);
        return redirect()->back()->withInput()->with('success', 'image upload successfully.');
    }
    /**
     * [viewFriendlist description]
     * @return [type] [description]
     */
    public function viewFriendlist()
    {
        $id =  Auth::user()->id;
        $data['users'] = $this->dashboardObj->queryData($id);
        return view('user.viewFriendlist', $data);
    }
    /**
     * [addFriend description]
     */
    public function addFriend($id)
    {
        $sender_id = Auth::user()->id;
        $receiver_id = $id;
        $friendship_records = Friendship::select('friendship', ['sender_id','receiver_id','status'], ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
        if (count($friendship_records) == 0) {
            Friendship::insert('friendship', ['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
        }
        else
        {
            foreach ($friendship_records as $key) {
                # code...
                $status = $key->status;
            }
            if($status != 0)
            {
  
            }
            else
            {
             $update = Friendship::update('friendship', ['status'=>0],['sender_id'=>$sender_id,'receiver_id'=>$receiver_id]);
            }
        }
        return redirect('friendlist')->with(['success'=>'friend request successfully sent']);
    }

    public function cancelFriendRequest($id)
    {

    }
    /**
     * @DateOfCreation         23 August 2018
     * @ShortDescription       Destroy the session and Make the Auth Logout
     * @return                 Response
     */
    public function getLogout()
    {
        // logout from auth facade
        Auth::logout();
        // destroy or clear session
        Session::flush();
        // redirect to main page
        return redirect('/');
    }
}
