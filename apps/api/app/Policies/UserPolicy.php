<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['admin', 'super-admin']);
    }

    public function view(User $user, User $model)
    {
        // dd($user->id === $model->id);
        // admins can view all; users can view themselves
        return $user->hasAnyRole(['user','admin', 'super-admin']);
    }

    public function update(User $user, User $model)
    {
        // admins & super-admin can update others; user can update own profile (but not roles)
        if ($user->id === $model->id) {
            return true;
        }
        return $user->hasAnyRole(['admin', 'super-admin']);
    }

    public function delete(User $user, User $model)
    {
        // only admins and super-admin and not self; backend controller enforces more
        return $user->hasAnyRole(['admin', 'super-admin']) && $user->id !== $model->id;
    }
}
