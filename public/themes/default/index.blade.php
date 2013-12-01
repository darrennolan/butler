@extends('default.layout')

@section('content')

<div class="container">
    <!-- Example row of columns -->
    <div class="row">

        <div class="col-md-12">

            @foreach (ButlerFlow::thePosts() as $post)
                <h2><a href="{{ URL::to($post->thePermalink()) }}">{{$post->theTitle()}}</a></h2>
                <div class="the-content">
                    {{$post->theContent()}}

                    @if ($post->hasMore())
                    <p><a href="{{URL::to($post->thePermalink())}}">Read More...</a></p>
                    @endif
                </div>
                <hr>
            @endforeach

            @if (ButlerFlow::thePosts()->count() == 0)
                <p>No Posts</p>
            @endif

            @if (ButlerFlow::hasLinks())
                {{ ButlerFlow::thePosts()->links() }}
            @endif

        </div> <!-- eo col-md-12 -->

    </div> <!-- eo row -->

</div> <!-- eo container -->

@stop
