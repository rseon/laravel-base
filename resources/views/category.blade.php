@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Category') }} : {{ $category->name }}</h1>
        <h2>{{ __('Posts') }}</h2>

        @include('post._listing')
        {{ $posts->links() }}
    </div>
@endsection
