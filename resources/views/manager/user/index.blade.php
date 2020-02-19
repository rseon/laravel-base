@extends('layouts.manager')

@section('content')
    <div class="container">
        <h1>{{ __('Users') }}</h1>

        @isset(request()->trashed)
            <p><a href="{{ route('manager.users.index') }}">{{ __('Show regular') }}</a></p>
        @else
            <p><a href="{{ route('manager.users.create') }}">{{ __('Create user') }}</a></p>
            <p><a href="{{ route('manager.users.index', ['trashed' => true]) }}">{{ __('Show trashed') }}</a></p>
        @endisset


        <table class="table table-hovered">
            <thead>
            <tr>
                <th width="1">#</th>
                <th width="1" class="text-nowrap">{{ __('Role') }}</th>
                <th>{{ __('Name') }}</th>
                <th width="1" class="text-nowrap">{{ __('Email') }}</th>
                <th width="1" class="text-nowrap">{{ __('Created') }}</th>
                @isset(request()->trashed)
                    <th width="1" class="text-nowrap">{{ __('Deleted') }}</th>
                @endisset
                <th width="1" class="text-nowrap">{{ __('Active') }}</th>
                <th width="1"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="text-muted">{{ $user->id }}</td>
                    <td class="text-nowrap">{!! display_role($user->role) !!}</td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td class="text-nowrap">{{ $user->email }}</td>
                    <td class="text-nowrap">{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                    @isset(request()->trashed)
                        <td class="text-nowrap">{{ $user->deleted_at->format('d/m/Y H:i:s') }}</td>
                    @endisset
                    <td class="text-nowrap text-center">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" disabled @if($user->is_active) checked @endif />
                            <label class="custom-control-label"></label>
                        </div>
                    </td>
                    <td>
                        @isset(request()->trashed)
                            <a href="{{ route('manager.users.restore', $user) }}" onclick="return confirm('{{ __('Are you sure ?') }}')">{{ __('Restore') }}</a>
                        @else
                            <a href="{{ route('manager.users.edit', $user) }}">{{ __('Edit') }}</a>
                        @endisset
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection
