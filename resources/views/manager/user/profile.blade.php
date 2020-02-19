@extends('layouts.manager')

@section('content')
    <div class="container">
        <h1>{{ __('My profile') }}</h1>
        <form action="{{ route('manager.user.update_profile') }}" method="post">
            @csrf
            @method('PUT')

            @include('manager.user._form')

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
