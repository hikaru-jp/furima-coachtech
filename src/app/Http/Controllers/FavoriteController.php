<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle($item_id)
    {
        $user = Auth::user();

        $existingFavorite = Favorite::where('user_id', $user->id)->where('item_id', $item_id)->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'item_id' => $item_id,
            ]);
        }

        return back();
    }
}
