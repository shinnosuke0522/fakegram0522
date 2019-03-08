<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Post;
use App\Photo;
use Illuminate\Http\Request;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_user = User::all();
        dd($all_user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mypage()
    {
        $user = User::find(Auth::id());
        $posts = $user->posts;
        $photos = [];
        $sum_count = 0;
        foreach($posts as $post){
            $sum_count += $post->likes_count;
            $photo = Photo::where('post_id',$post->id)->orderBy('created_at')->first();
            $photos[] = $photo;
        }
        return view('user.my_page')->with('user', $user)->with('photos', $photos)->with('sum_count', $sum_count);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $posts = $user->posts;
        $photos = [];
        $sum_count = 0;
        foreach($posts as $post){
            $sum_count += $post->likes_count;
            $photo = Photo::where('post_id', $post->id)->orderBy('created_at')->first();
            $photos[] = $photo;
        }
        //dd($sum_count);
        return view('user.user_page')->with('user', $user)->with('photos', $photos)->with('sum_count', $sum_count);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        //dd($user->email);
        return view('user.user_edit', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:40',
            'email' => 'required|max:70',
            'avater' => ['file', 'image', 'mimes:jpeg,png'],
        ]);
        
        // update current user information
        $currnet_user = Auth::user();
        $currnet_user->name = $request->name;
        $currnet_user->email = $request->email;

        // if avater is updated
        if($request->file('avater'))
        {
            $name = time(). '.'.  $request->file('avater')->getClientOriginalExtension();
            $avater = $request->file('avater')->getRealPath();
            $image = Image::make($avater)->resize(80,80);
            $image->save(public_path('/uploads/'. $name));
            $avater = base64_encode(file_get_contents(public_path('/uploads/'. $name)));
            $currnet_user->avater = $avater;
        }
        // save updated currnet user's informtaion
        $currnet_user->save();
        
        // return view
        return redirect('/home');
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