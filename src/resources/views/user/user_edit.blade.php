@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-title">
                <h2 class="text-center" >Edit Your account information</h2>
            </div>
            <div class="card-body">

                {{-- Error message  --}}
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-warning" role="alert">
                        <strong>Error : </strong>{{$error}}
                    </div>
                    @endforeach
                @endif

                {{-- User edit form --}}
                {{-- <form method="post" enctype='multipart/form-data'> --}}
                <form method="post" action="{{url('/my_page/update')}}" enctype='multipart/form-data'>
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_name"><h5>Name</h5></label>
                        <input class="form-control" type="text"
                            name="name" id="edit_name" value="{{$user->name}}">
                    </div>

                    <div class="form-group">
                        <label for="edit_mail"><h5>Email Address</h5></label>
                        <input class="form-control" type="email" 
                            name="email" id="edit_mail" value="{{$user->email}}">
                    </div>

                    <div class="form-group">
                        <h5>Avater</h5>
                        <input type="file" name="avater" class="btn btn-sm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>

                    <button type="submit" class="btn btn-lg btn-block btn-primary float-right mt-3">
                        Update Profile
                     </button>  

                </form>
            </div>
        </div>

    </div>
@endsection