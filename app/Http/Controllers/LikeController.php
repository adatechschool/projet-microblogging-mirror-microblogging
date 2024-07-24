<?php
// update the file on 24/07
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likePost(Request $request, Post $post)
    {
        $post->likes()->create(['user_id' => $request->user()->id]);

        return response()->json(['message' => 'Liked post']);
    }

    public function unlikePost(Request $request, Post $post)
    {
        $post->likes()->where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Unliked post']);
    }

    public function likeComment(Request $request, Comment $comment)
    {
        $comment->likes()->create(['user_id' => $request->user()->id]);

        return response()->json(['message' => 'Liked comment']);
    }

    public function unlikeComment(Request $request, Comment $comment)
    {
        $comment->likes()->where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Unliked comment']);
    }
}

