 @foreach($comments as $comment)
    <div class="display-comment">
        <strong>{{ $comments->user->name }}</strong>
        <p>{{ $comments->comment }}</p>
        <a href="" id="reply"></a>
        <form method="post" action="">
            @csrf
            <div class="form-group">
                <input type="text" name="comment_body" class="form-control" />
                <input type="hidden" name="post_id" value="" />
                <input type="hidden" name="comment_id" value="" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Reply" />
            </div>
        </form>
        @include('partials._comment_replies', ['comments' => $comments->replies])
    </div>
@endforeach