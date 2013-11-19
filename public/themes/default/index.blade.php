@extends('default.layout')

@section('content')

<div class="the-content">
    @foreach (ButlerFlow::thePosts() as $post)
        <h2>{{$post->title}}</h2>
        <div class="the-content">
            {{$post->content}}
        </div>
    @endforeach

    @if (ButlerFlow::thePosts()->count() == 0)
        <p>No Posts</p>
    @endif

    {{ ButlerFlow::thePosts()->links() }}
</div>

@stop
