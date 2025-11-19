<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            if ($user->img_url && Storage::disk('public')->exists($user->img_url)) {
                Storage::disk('public')->delete($user->img_url);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->img_url = $path;
        }

        $user->name = $request->input('name');

        $user->is_profile_completed = true;

        $user->save();

        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->input('postal_code'),
                'address_line' => $request->input('address_line'),
                'building_name' => $request->input('building_name'),
            ],
        );

        return redirect()->route('mypage.profile');
    }
}
