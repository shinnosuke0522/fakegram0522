@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-title">
                Edit Your account information
            </div>
            <div class="card-body">
                <form method="post"  enctype='multipart/form-data'>
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection