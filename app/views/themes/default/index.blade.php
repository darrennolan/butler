@extends('themes.default.layout')

@section('content')

<div>
    @foreach (ButlerFlow::thePosts() as $post)
        <h1>{{$post->title}}</h1>
        <div class="the-content">
            {{$post->content}}
        </div>
    @endforeach

    @if (ButlerFlow::thePosts()->count() == 0)
        No Posts
    @endif

    <div class="navigation">
        {{ ButlerFlow::thePosts()->links() }}
    </div>
</div>

@stop
