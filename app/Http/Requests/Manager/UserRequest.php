<?php

namespace App\Http\Requests\Manager;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $from_profile = Route::currentRouteName() === 'manager.user.update_profile';

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ];

        if(!$from_profile) {
            $rules['role'] = ['required', Rule::in(array_keys(User::getRoles()))];
            $rules['is_active'] = 'boolean';
        }

        // Update
        if($this->user) {
            $rules['email'] = 'required|email|unique:users,email,'.$this->user->id;
        }
        elseif($from_profile) {
            $rules['email'] = 'required|email|unique:users,email,'.Auth::id();
        }
        else {
            $rules['password'] = 'required|string|min:8';
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $data = [
            'email' => Str::lower($this->email),
            'is_active' => (int) $this->is_active === 1,
        ];

        if($this->password) {
            $data['password'] = Hash::make($this->password);
        }
        $this->merge($data);
    }
}

