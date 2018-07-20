@extends('layouts.app')

@section('content')
    <div class="container">
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="card" style="height:15vh; margin-top:10px;">
                <ul class="list-group list-group-flush">
                <div class="row">
                    <li class="list-group-item">
                        <div class="col-md-4 col-sm-4">
                        <img style="width:100%;" src="/storage/cover_images/{{$post->cover_image}}">
                        </div>
                    </li>
                    <li class="list-group-item">
                    <div class="col-md-8 col-sm-8">
                            <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                            <small>Written on {{$post->created_at}}</small>
                            <small> Written by {{$post->user->name}}</small>
                    </div>
                </li>
                </div>
                </ul>
                
            </div>
            <hr>
        @endforeach
        {{$posts->links()}}
    @else
        <p>NO POSTS FOUND</p>
    @endif
        </div>       
@endsection