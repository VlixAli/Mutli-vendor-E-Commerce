<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Locale;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.profile.edit', [
            'user' => $user,
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames(),
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $attributes = $request->validated();

        $user = Auth::user();

        $user->profile->fill($attributes)->save();

        $profile = $user->profile;

        return redirect()->route('dashboard.profile.edit')
            ->with('success' , 'Profile Updated!');
    }
}
