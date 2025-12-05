<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class); // Policy check
        return response()->json(User::with('profile','roles')->paginate(15));
    }

    public function show($id)
    {
        $this->authorize('view', User::class);
        $user = User::with('profile','roles')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', User::class);
        $user = User::findOrFail($id);
        $user->fill($request->only(['name','email','status']));
        $user->save();

        if ($request->filled('roles')) {
            $user->syncRoles($request->roles);
        }

        $user->profile()->update($request->only([
            'full_name','gender','date_of_birth','phone_number','address',
            'job_title','department','avatar_url','bio','status'
        ]));

        return response()->json($user->load('profile','roles'));
    }
}
