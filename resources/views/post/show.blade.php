@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p>
            {{ $post->content }}
        </p>
        <p>@include('post._meta')</p>
    </div>
@endsection
