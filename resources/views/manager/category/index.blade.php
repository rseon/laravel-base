@extends('layouts.manager')

@section('content')
    <div class="container">
        <h1>{{ __('Categories') }}</h1>

        <p><a href="{{ route('manager.categories.create') }}">{{ __('Create category') }}</a></p>


        <table class="table table-hovered">
            <thead>
            <tr>
                <th width="1">#</th>
                <th>{{ __('Name') }}</th>
                <th width="1" class="text-nowrap">{{ __('Posts') }}</th>
                <th width="1"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="text-muted">{{ $category->id }}</td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td class="text-nowrap">{{ trans_choice('counter_posts', $category->posts_count) }}</td>
                    <td>
                        <a href="{{ route('manager.categories.edit', $category) }}">{{ __('Edit') }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
