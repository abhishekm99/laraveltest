@extends('layouts.app')

@section('content')
    <div class="container">
    <a href="/posts" class="btn btn-dark">Go Back</a>
    <h1>Edit Post</h1>
    {!! Form::open(["action" => ["PostController@update", $post->id], "method" => "POST", "class" => "form", 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::textarea('body', $post->body, ['class' => 'form-control', 'placeholder' => 'Body', 'id' => 'article-ckeditor'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}

        </div>
        {{Form::hidden('_method','PUT')}}
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    </div>       
@endsection