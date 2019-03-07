@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="row">
                <div class="col-sm-2">
                    <img src="data:image/jpg;base64,{{$user->avater}}" class="avater_img">
                </div>
                <div class="col-sm-8" style="margin-top: 25px;">
                    <h3>{{$user->name}}</h3>
                </div>
            </div>
        </div>
        
        @if($photos)
            <h3 class="mb-1">Posts</h3>
            @foreach ($photos as $photo)
                <div class="card float-left">
                    <img src="{{$photo->url}}">
                </div>
            @endforeach
        @endif
    </div>
@endsection