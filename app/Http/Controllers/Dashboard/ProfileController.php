<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $attributes = $request->validated();

        $user = Auth::user();

        $user->profile->fill($attributes)->save();

        $profile = $user->profile;

    }
}
