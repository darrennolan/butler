@extends('default.layout')

@section('content')

<div>
    <h1>{{ ButlerHTML::sitename() }}</h1>

    {{ ButlerHTML::homepage() }}

    @foreach (ButlerFlow::thePosts() as $post)
        <h2>{{$post->title}}</h2>
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
