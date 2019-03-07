@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <h2> Like </h2>
            <ul class="list-group">
                @if($likes)
                    @foreach ($likes as $like)
                        <a href="/users/{{$like->user->id}}">
                            <li class="list-group-item">
                                <div class="row">
                                    @if($like->user->avater)
                                        <div class="col-sm-1">
                                            <img src="data:image/jpg;base64,{{$like->user->avater}}" class="post_top_img">
                                        </div>
                                    @endif
                                    <div class="col-sm-8">
                                        <h3 class="mt-1">{{$like->user->name}}</h3>
                                    </div>
                                </div>
                            </li>
                        </a>
                    @endforeach
                @else
                    <li class="list-group-item">no Likes</li>
                @endif
            </ul>
        </div>
    </div>
@endsection