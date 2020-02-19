@extends('layouts.manager')

@section('content')
    <div class="container">
        <h1>{{ __('Edit user') }}</h1>
        <p><a href="{{ route('manager.users.index') }}">{{ __('Back to the list') }}</a></p>

        <form action="{{ route('manager.users.update', $user) }}" method="post">
            @csrf
            @method('PUT')

            @include('manager.user._form')

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update') }}
                    </button>
                    <a href="{{ route('manager.users.index') }}" class="btn btn-warning">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </div>
        </form>

        <form action="{{ route('manager.users.destroy', $user) }}" method="post">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure ?') }}')">
                {{ __('Delete') }}
            </button>
        </form>
    </div>
@endsection
