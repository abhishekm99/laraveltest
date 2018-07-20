@extends('layouts.app')

@section('content')
    <div class="container">
    <a href="/posts" class="btn btn-dark">Go Back</a>
    <h1>Create Post</h1>
    {!! Form::open(["action" => "PostController@store", "method" => "POST", "class" => "form", 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Body', 'id' => 'article-ckeditor'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}

        </div>
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    </div>       
@endsection