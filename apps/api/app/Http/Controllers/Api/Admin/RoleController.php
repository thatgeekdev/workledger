<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends Controller
{
    public function index()
    {
        // Return all roles (id and name)
        $roles = Role::get();
        // return response()->json(Roles::with('profile','roles')->paginate(15));
        return response()->json($roles);
    }
    public function update(Request $request, $id)
    {
        $roles = Role::findOrFail($id);
        $roles->fill($request->only(['name','email','status']));
        $roles->save();
        return response()->json($roles);
    }
}
