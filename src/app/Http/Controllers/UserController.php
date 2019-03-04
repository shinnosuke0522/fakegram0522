<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
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
        //$current_user = Auth::user();
        return view('user.my_page');
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
        //
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
            'avater' => [
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
            ]
        ]);
        // update current user information
        $currnet_user = Auth::user();
        $currnet_user->name = $request->name;
        $currnet_user->email = $request->email;

        // if avater is updated
        $avater_url = "";
        if($request->file('avater'))
        {
            // if current user has an avater image
            if($currnet_user->avater)
            {
                $previous_url = $currnet_user->avater;
                $elements_url = explode("/", $previous_url);
                $pointer = count($elements_url) - 1;
                $publicId = $elements_url[$pointer];
                Cloudder::delete($publicId);
            }

            // set an new avater image  
            $avater = $request->file('avater');
            $name = time() . '.' . $avater->getClientOriginalExtension();
            // resize selected image and save at 'uploads' folder in public
            $avater_img = Image::make($avater->getRealPath())->resize(200,200);
            $avater_img->save(public_path('/uploads/' . $name ));
            // upload processed image and set url 
            $avater_path = public_path('/uploads/' . $name );
            Cloudder::upload($avater_path, null);
            $avater_url = "http://res.cloudinary.com/denviv6mo/image/upload/" . Cloudder::getPublicId();
            $currnet_user->avater = $avater_url;
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