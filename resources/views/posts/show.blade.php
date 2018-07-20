@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
    <a href="/posts" class="btn btn-dark">Go Back</a>
    <h1>{{$post->title}}</h1>
    <img style="width:100%;height:70vh;" src="/storage/cover_images/{{$post->cover_image}}">
    <small> Written on {{$post->created_at}}</small>
    <small> Written by {{$post->user->name}}</small>
    <hr>
    <div>
        <p>{!!$post->body!!}</p>
    </div>
    <hr>
    @if(!Auth::guest())
    @if(Auth::user()->id == $post->user_id)
    <a href="/posts/{{$post->id}}/edit" class="btn btn-dark">Edit</a>
    {!!Form::open(['action' => ['PostController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
    {!!Form::close()!!}
    @endif
    @endif
    </div>       
@endsection