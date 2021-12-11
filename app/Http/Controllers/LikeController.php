<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
class LikeController extends Controller
{
    public function store(Request $request)
    {
        $like = new Like;
        $like->user()->associate($request->user());
        $post = Post::find($request->get('post_id'));
        $post->post_likes()->save($like);

        return back();
    }
}
