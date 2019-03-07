<?php

namespace App\Http\Controllers;

use Auth;
use App\Like;
use App\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function show($post_id)
    {
        $likes = Post::find($post_id)->likes;
        return view('likes')->with('likes', $likes);
    }

    public function store(Request $request, $post_id)
    {
        $new_like = new Like;
        $new_like->u_id = Auth::id();
        $new_like->post_id = $post_id;
        $new_like->save();

        return redirect('home');
    }

    public function delete($post_id)
    {
        $like = Like::where('u_id', Auth::id())->where('post_id', $post_id)->first();
        $like->delete();
        return redirect('home');
    }
}
