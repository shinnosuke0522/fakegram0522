@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="row">
                <div class="col-sm-2">
                    @if($user->avater)
                        <img src="data:image/jpg;base64,{{$user->avater}}" class="avater_img">
                    @endif
                </div>
                <div class="col-sm-6" style="margin-top: 25px;">
                    <h3>{{$user->name}}</h3>
                </div>
                <div class="col-sm-4">
                    <h3 style="margin-top: 25px;"><strong>Like: </strong>{{$sum_count}}</h3>
                </div>
            </div>
        </div>
        
        @if($photos)
            <h3 class="mb-1">Posts</h3>
            @foreach ($photos as $photo)
                <div class="card float-left">
                    <img src="{{$photo->url}}"  height="350" width="350">
                </div>
            @endforeach
        @endif
    </div>
@endsection