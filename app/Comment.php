<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'post_comments';
	/**
	 * [user description]
	 * @return [type] [description]
	 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * [replies description]
     * @return [type] [description]
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
