<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class MyPageController extends Controller
{
    /**
     * マイページトップ
     * GET /mypage
     */
    public function index()
    {
        $user = Auth::user();
        return view('mypage.index', compact('user'));
    }

    /**
     * 出品履歴ページ
     * GET /mypage/sold
     */
    public function soldItems()
    {
        $user = Auth::user();
        $soldItems = $user->items()->latest()->get();

        return view('mypage.sold_items', compact('user', 'soldItems'));
    }

    /**
     * 購入履歴ページ
     * GET /mypage/purchased
     */
    public function purchasedItems()
    {
        $user = Auth::user();
        $purchasedItems = $user->purchases()->with('item')->latest()->get();

        return view('mypage.purchased_items', compact('user', 'purchasedItems'));
    }

}
