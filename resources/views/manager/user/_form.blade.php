@if(\Illuminate\Support\Facades\Route::currentRouteName() !== 'manager.user.profile')
    <div class="form-group row">
        <label for="is_active" class="col-md-4 col-form-label text-md-right"></label>

        <div class="col-md-6">

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="is_active" id="is_active" value="1" @if(old('is_active') || isset($user) && $user->is_active) checked @endif />
                <label class="custom-control-label" for="is_active">{{ __('Active') }}</label>
            </div>

            @error('active')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
@endif

<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name ?? '' }}" />

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email ?? '' }}" />

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" />
        @isset($user)
            <span class="text-muted">{{ __('Leave it empty to not change') }}</span>
        @endisset

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

@if(\Illuminate\Support\Facades\Route::currentRouteName() !== 'manager.user.profile')
    <div class="form-group row">
        <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

        <div class="col-md-6">
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                <option value=""></option>
                @foreach($roles as $k => $v)
                    <option
                        value="{{ $k }}"
                        @if(old('role') && old('role') === $k || isset($user) && $user->role === $k)
                            selected
                        @endif
                    >{{ $v }}</option>
                @endforeach
            </select>

            @error('role')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
@endisset
