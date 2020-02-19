@extends('layouts.manager')

@section('content')
    <div class="container">
        <h1>{{ __('Edit category') }}</h1>
        <p><a href="{{ route('manager.categories.index') }}">{{ __('Back to the list') }}</a></p>

        <form action="{{ route('manager.categories.update', $category) }}" method="post">
            @csrf
            @method('PUT')

            @include('manager.category._form')

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update') }}
                    </button>
                    <a href="{{ route('manager.categories.index') }}" class="btn btn-warning">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </div>
        </form>

        <form action="{{ route('manager.categories.destroy', $category) }}" method="post">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure ?') }}')">
                {{ __('Delete') }}
            </button>
        </form>
    </div>
@endsection
