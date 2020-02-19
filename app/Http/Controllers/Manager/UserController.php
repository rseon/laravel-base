<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Manager\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::latest();

        if($request->trashed) {
            $users->onlyTrashed();
        }

        $users = $users->paginate(10);
        return view('manager.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.user.create', [
            'roles' => User::getRoles(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Manager\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        $user = User::create($validated);

        return redirect()->route('manager.users.index')->withSuccess(__('User created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('manager.user.edit', [
            'user' => $user,
            'roles' => User::getRoles(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Manager\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        if($request->password) {
            $validated['password'] = $request->password;
        }

        $user->update($validated);

        return redirect()->route('manager.users.edit', $user)->withSuccess(__('User updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if(Auth::id() === $user->id) {
            return redirect()->route('manager.users.edit', $user)->withErrors(__('You can\'t delete your own account'));
        }

        $user->delete();

        return redirect()->route('manager.users.index')->withSuccess(__('User deleted'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        User::withTrashed()->find((int) $request->user)->restore();

        return redirect()->route('manager.users.index')->withSuccess(__('User restored'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('manager.user.profile', compact('user'));
    }

    public function updateProfile(UserRequest $request)
    {
        $user = Auth::user();

        $validated = $request->validated();
        if($request->password) {
            $validated['password'] = $request->password;
        }

        $user->update($validated);

        return redirect()->route('manager.user.profile')->withSuccess(__('Profile updated'));
    }
}
