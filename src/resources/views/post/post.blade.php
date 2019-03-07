@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1> Post your favorite photos </h1>

                {{-- Error message  --}}
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-warning" role="alert">
                        <strong>Error : </strong>{{$error}}
                    </div>
                    @endforeach
                @endif
            </div>

            <div class="card-body">
                <form method="post" action="{{url('post/store')}}" enctype='multipart/form-data'>
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <h5>Photos</h5>
                        <input type="file" class="btn btn-sm" name="photos[]" multiple>
                    </div>

                    <div class="form-group">
                        <h5>Comment</h5>
                        <textarea　class="form-control" name="comment" rows="4" placeholder="wtire your comment">
                        </textarea>
                    </div>
                    
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-lg btn-block btn-primary float-right mt-3">
                        <p style="font-size: 20px;"> Post photos ! </p>
                    </button>  
                </form>
            </div>
        </div>
    </div>
@endsection