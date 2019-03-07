@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h1>Time Line</h1>


    @foreach($data as $d)
        <div class="card mb-5" style="width: 40rem;">

           <div class="card-header post_top">
               <div class="row">
                    <div class="col-sm-3">
                        @if($d->user->avater)
                            <img src="data:image/jpg;base64,{{$d->user->avater}}" class="post_top_img">
                        @endif
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <h3>
                            <a href="/users/{{ $d->user->id }}">
                                {{$d->user->name}}
                            </a>
                        </h3>
                    </div>
               </div>
           </div>

           <div class="card-body">
                <div class="carousel slide mb-3" data-ride="carousel" style="text-align:center;">
                    <div class="carousel-inner md-1">
                        @for($i = 0; $i < count($d->photos); $i++)
                            @if($i==0)
                                <div class="carousel-item active">
                                    <img src="{{$d->photos[$i]['url']}}" class="d-block"
                                        style="margin: auto;" height="350" width="350">   
                                </div>
                            @else
                                <div class="carousel-item">
                                    <img src="{{$d->photos[$i]['url']}}" class="d-block"
                                        style="margin: auto;" height="350" width="350"> 
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-7">
                        @if($d->comment)
                            <div class="comment-area">
                                <h4>Comment:</h4>
                                <p>{{$d->comment}}</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-5">
                        @if(Auth::user()->id != $d->u_id)
                           @if(in_array($d->id, $ids, true))
                                <form method='post' action="{{ action('LikesController@delete', $d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link like float-right">
                                        <span class="fas fa-thumbs-up"></span>
                                    </button>
                                </form>
                           @else
                                <form method="post" action="{{ action('LikesController@store', $d->id) }}">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-link like float-right">
                                        <span class="far fa-thumbs-up"></span>
                                    </button>
                                </form>
                            @endif
                        @endif
                        
                        <a class="float-right mt-3" href="posts/{{$d->id}}/likes/list">
                            <button class="btn btn-link">Likes</button>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>

@endsection
