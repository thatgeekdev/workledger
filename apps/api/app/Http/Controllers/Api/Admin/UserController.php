<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return response()->json(User::with('profile','roles')->paginate(15));
    }

    public function show($id)
    {
        // $this->authorize('view', User::class);
        $user = User::with('profile','roles')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // $this->authorize('update', User::class);

        $currentUser = Auth::user();
        $user = User::findOrFail($id);

        // Prevent editing super-admin roles by admin (only super-admin may change super-admin)
        $isTargetSuperAdmin = $user->hasRole('super-admin');
        $isRequesterSuperAdmin = $currentUser->hasRole('super-admin');

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes','email', Rule::unique('users')->ignore($user->id)],
            'status' => ['sometimes', Rule::in(['active','inactive','absent'])],
            'roles' => 'sometimes|array',
            'roles.*' => 'string'
        ]);

        // Update basic fields
        $user->fill($request->only(['name','email','status']));
        $user->save();

        // If roles present, enforce RBAC rules:
        if ($request->filled('roles')) {
            $newRoles = $request->input('roles', []);

            // Only admin or super-admin are allowed to assign roles
            if (! $currentUser->hasAnyRole(['admin','super-admin'])) {
                return response()->json(['message' => 'Unauthorized to assign roles'], 403);
            }

            // Admin (non super-admin) cannot modify roles of a super-admin
            if ($isTargetSuperAdmin && ! $isRequesterSuperAdmin) {
                return response()->json(['message' => 'Cannot modify roles of a super-admin'], 403);
            }

            // Prevent users from assigning themselves higher roles via admin UI:
            if ($currentUser->id === $user->id && ! $currentUser->hasRole('super-admin')) {
                // disallow changing own roles unless super-admin
                return response()->json(['message' => 'Cannot change your own roles'], 403);
            }

            // Sync roles (Spatie)
            $user->syncRoles($newRoles);
        }

        // Update or create profile fields
        if ($request->hasAny([
            'full_name','gender','date_of_birth','phone_number','address',
            'job_title','department','avatar_url','bio','status'
        ])) {
            $user->profile()->update($request->only([
                'full_name','gender','date_of_birth','phone_number','address',
                'job_title','department','avatar_url','bio','status'
            ]));
        }

        return response()->json($user->load('profile','roles'));
    }

    public function destroy($id)
    {
        // $this->authorize('delete', User::class);

        $currentUser = Auth::user();
        $user = User::findOrFail($id);

        // Prevent deleting self (you probably don't want that) and protect super-admin
        if ($user->id === $currentUser->id) {
            return response()->json(['message' => 'Cannot delete your own account'], 403);
        }

        if ($user->hasRole('super-admin')) {
            return response()->json(['message' => 'Cannot delete super-admin'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
