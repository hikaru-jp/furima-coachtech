<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\Purchase;

class MyPageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        if ($page === 'sell') {
            $items = Item::query()->where('user_id', $user->id)->latest()->get();
        } else {
            $items = Purchase::query()->where('user_id', $user->id)->with('item')->latest()->get();
        }

        return view('mypage.index', compact('user', 'page', 'items'));
    }

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

        $user->name = $request->name;
        $user->save();

        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->postal_code,
                'address_line' => $request->address_line,
                'building_name' => $request->building_name,
            ],
        );
        return redirect()->route('mypage.index');
    }
}
