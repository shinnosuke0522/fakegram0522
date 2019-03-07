<?php

namespace App\Http\Controllers;

use App\Post;
use App\photo;
use Auth;
use App\User;
use App\like;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::orderBy('id', 'desc')->get();
        $ids = [];
        $likes = Like::where('u_id', Auth::id())->get();
        foreach($likes as $like)
        {
            $ids[] = $like->post_id;
        }
        return view('home')->with('data', $data)->with('ids', $ids);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $this->validate($request,[
            'comment' => 'max:200',
            'photos' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // insert new post
        $new_post = new Post;
        $new_post->comment = $request->comment;
        $new_post->u_id = Auth::id();
        $new_post->save();

        //get the new post's id
        $new_post_id = $new_post->id;
        foreach($request->file('photos') as $photo){
            //upload photo
            Cloudder::upload($photo->getRealPath(), null);

            // get url
            $size = 350;
            $p_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $size, "height"=>$size]);

            // insert to DB
            $new_photo = new Photo;
            $new_photo->post_id = $new_post_id;
            $new_photo->url = $p_url;
            $new_photo->save();
        }
        
        // redirect to home
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
