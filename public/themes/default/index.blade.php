@extends('default.layout')

@section('content')

<div class="container">
    <!-- Example row of columns -->
    <div class="row">

        <div class="col-md-12">

            @foreach (ButlerFlow::thePosts() as $post)
                <h2>{{$post->title}}</h2>
                <div class="the-content">
                    {{$post->theContent()}}
                </div>
                <hr>
            @endforeach

            @if (ButlerFlow::thePosts()->count() == 0)
                <p>No Posts</p>
            @endif

            {{ ButlerFlow::thePosts()->links() }}

        </div> <!-- eo col-md-12 -->

    </div> <!-- eo row -->

</div> <!-- eo container -->

@stop
