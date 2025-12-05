<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function me()
    {
        $user = Auth::user()->load('profile','roles');
        return response()->json($user);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        // Update user fields
        if (isset($data['name'])) $user->name = $data['name'];
        if (isset($data['email']) && $data['email'] !== $user->email) {
            $user->email = $data['email'];
        }
        $user->save();

        // Update profile
        $user->profile()->update($request->only([
            'full_name','gender','date_of_birth','phone_number','address',
            'job_title','department','avatar_url','bio','status'
        ]));

        return response()->json($user->load('profile','roles'));
    }
}
