@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('All posts') }}</h1>
        @include('post._listing')

        {{ $posts->links() }}

    </div>
@endsection
