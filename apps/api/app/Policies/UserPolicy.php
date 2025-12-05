<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

    public function __construct()
    {
        //
    }

    public function viewAny($user)
    {
        return $user->hasAnyRole(['admin','super-admin']);
    }

    public function view($user, User $model)
    {
        return $user->hasAnyRole(['user','admin','super-admin']);
    }

    public function update($user, User $model)
    {
        return $user->hasAnyRole(['admin','super-admin']);
    }
}
