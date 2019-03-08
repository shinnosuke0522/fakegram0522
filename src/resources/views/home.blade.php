@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h1>Time Line</h1>


    @foreach($posts as $post)
        <div class="card mb-5" style="width: 40rem;">

           <div class="card-header post_top">
               <div class="row">
                    <div class="col-sm-3">
                        @if($post->user->avater)
                            <img src="data:image/jpg;base64,{{$post->user->avater}}" class="post_top_img">
                        @endif
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <h3>
                            <a href="/users/{{ $post->user->id }}">
                                {{$post->user->name}}
                            </a>
                        </h3>
                    </div>
               </div>
           </div>

           <div class="card-body">
                <div class="carousel slide mb-3" data-ride="carousel" style="text-align:center;">
                    <div class="carousel-inner md-1">
                        @for($i = 0; $i < count($post->photos); $i++)
                            @if($i==0)
                                <div class="carousel-item active">
                                    <img src="{{$post->photos[$i]['url']}}" class="d-block"
                                        style="margin: auto;" height="350" width="350">   
                                </div>
                            @else
                                <div class="carousel-item">
                                    <img src="{{$post->photos[$i]['url']}}" class="d-block"
                                        style="margin: auto;" height="350" width="350"> 
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-7">
                        @if($post->comment)
                            <div class="comment-area">
                                <h4>Comment:</h4>
                                <p>{{$post->comment}}</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-5">
                        @if(Auth::check())
                            @if(Auth::user()->id != $post->u_id)
                                @if(in_array($post->id, $ids, true))
                                    <form method='post' action="{{ action('LikesController@delete', $post->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link like float-right">
                                            <span class="fas fa-thumbs-up"></span>
                                        </button>
                                    </form>
                                @else
                                    <form method="post" action="{{ action('LikesController@store', $post->id) }}">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-link like float-right">
                                            <span class="far fa-thumbs-up"></span>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @endif

                        <a class="float-right mt-3" href="posts/{{$post->id}}/likes/list">
                            <button class="btn btn-link">Likes:{{$post->likes_count}} </button>
                        </a>
                        {{-- <button type="button" class="btn btn-link float-right mt-3" data-toggle="modal"
                             data-target="#likesModal" data-post="{{$post}}">
                             Likes: {{$post->likes_count}}
                        </button>

                        <div class="modal fade" id="likesModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">  
                                        <h5 class="modal-title" id="liks_title">New message</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
    {{$posts->links()}}
</div>

@endsection
