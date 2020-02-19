@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Latest posts') }}</div>

                <div class="card-body">
                    @include('post._listing')

                    <a href="{{ route('posts') }}">{{ __('See all') }}</a>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
