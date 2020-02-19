@extends('layouts.manager')

@section('content')
    <div class="container">
        <h1>{{ __('New user') }}</h1>
        <p><a href="{{ route('manager.users.index') }}">{{ __('Back to the list') }}</a></p>

        <form action="{{ route('manager.users.store') }}" method="post">
            @csrf

            @include('manager.user._form')

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
