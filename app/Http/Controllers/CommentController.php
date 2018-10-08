<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;

class CommentController extends Controller
{
	/**
	 * [store description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
     public function store(Request $request)
    {
        $comment_obj = new Comment;
        $comment_obj->comment = $request->get('comment_body');
        $comment_obj->user()->associate($request->user());
        $post = Post::find($request->get('post_id'));
        $post->comments()->save($comment_obj);

        return back();
    }
    /**
     * [replyStore description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function replyStore(Request $request)
    {
        $reply = new Comment();
        $reply->comment = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Post::find($request->get('post_id'));

        $post->comments()->save($reply);

        return back();

    }
}
