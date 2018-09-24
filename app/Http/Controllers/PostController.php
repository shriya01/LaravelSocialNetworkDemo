<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Users;
use Validator;
use App\MyModel;
use DB;

class PostController extends Controller
{
    /**
     * [viewUserPosts description]
     * @return [type] [description]
     */
    public function viewUserPosts()
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $friends = $user->getFriends()->toArray();
        $array = [];
        foreach ($friends as $key=>$value) {
            $id =  $value['id'];
            array_push($array, $id);
        }
        $posts = MyModel::getPostData($array);
        $data['posts'] = json_decode(json_encode($posts), true);
        $array = [];
        foreach ($data['posts'] as $key => $value) {
            $post_id = $data['posts'][$key]['id'];
            $likes =  MyModel::getColumnCount('post_likes', ['post_id'=>$post_id], 'like');
            $comments =  MyModel::getColumnCount('post_comments', ['post_id'=>$post_id], 'id');
            $comments_data = MyModel::select('post_comments',['post_id','user_id','comment'],['post_id'=>$post_id]);
            $data['posts'][$key]["likes"] = $likes;
            $data['posts'][$key]["comments"] = $comments;
            $data['posts'][$key]["comments_data"] = $comments_data;
        }

        $data['count'] = count($user->getFriendRequests()->toArray());
        $data['friends_count'] = count($user->getAcceptedFriendships()->toArray());
        return view('post.viewMyPosts', $data);
    }
    /**
     * [addNewPost description]
     */
    public function addNewPost()
    {
        $user_id =Auth::user()->id;
        $user = Users::find($user_id);
        $data['count'] = count($user->getFriendRequests()->toArray());
        $data['friends_count'] = count($user->getAcceptedFriendships()->toArray());
        return view('post.addNewPost', $data);
    }
    /**
     * [submitPost description]
     * @return [type] [description]
     */
    public function submitPost(Request $request)
    {
        $rules = array(
        'post_title'    => 'required',
        'post_description'     => 'required',
        'post_image'     => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        } else {
            $file = $request->file('post_image');
            $fileName = $file->getClientOriginalName();
            $destinationPath = 'public/files';
            $file->move($destinationPath, $file->getClientOriginalName());
            $postData = array(
            'post_title' => $request->input("post_title"),
            'post_description' => $request->input("post_description"),
            'post_image' => $fileName,
            'user_id' => Auth::user()->id
            );
            $user = MyModel::insert('posts', $postData);
            if ($user) {
                return redirect('/viewposts')->with('message', 'Post successfully added');
            } else {
                return redirect()->back()->withInput()->withErrors(__('messages.try_again'));
            }
        }
    }
    /**
     * [changeLikeStatus description]
     * @return [type] [description]
     */
    public function changeLikeStatus(Request $request)
    {
        header("Content-type: application/json");
        $text = $request->id;
        $post_id = $request->attrid;
        $user_id = Auth::user()->id;
        if ($text == "Like") {
            if (! MyModel::select('post_likes', ['post_id'], ['post_id'=>$post_id,'user_id'=>$user_id])) {
                $insertResult = MyModel::insert('post_likes', ['post_id'=>$post_id,'user_id'=>$user_id]);
            }
            $likes =  MyModel::getColumnCount('post_likes', ['post_id'=>$post_id], 'like');
            echo json_encode(array('text'=>'Unlike','likes'=>$likes));
        } else {
            $deleteResult = MyModel::delete('post_likes', ['post_id'=>$post_id,'user_id'=>$user_id]);
            $likes =  MyModel::getColumnCount('post_likes', ['post_id'=>$post_id], 'like');
            echo json_encode(array('text'=>'Like','likes'=>$likes));
        }
    }
    /**
     * [addComment description]
     * @param Request $request [description]
     */
    public function addComment(Request $request)
    {
        header("Content-type: application/json");
        $comment = $request->comment;
        $post_id = $request->postId;
        $user_id = Auth::user()->id;
        if (MyModel::insert('post_comments', ['post_id'=>$post_id,'user_id'=>$user_id,'comment'=>$comment])) {
            $comments =  MyModel::getColumnCount('post_comments', ['post_id'=>$post_id], 'id');
            echo json_encode(array('comments'=>$comments));
        }
    }
}
