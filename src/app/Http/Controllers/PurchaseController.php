<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function confirm($item_id)
    {
        // データ(仮)
        $item = (object) [
            'id' => $item_id,
            'name' => 'テスト商品',
            'price' => 5000,
            'image' => 'sample.jpg',
        ];

        return view('purchase.store', compact('item'));
    }

    public function store(Request $request, $item_id)
    {
        // 購入処理（仮）
        return redirect()
            ->route('mypage.index')
            ->with('success', "商品（ID: {$item_id}）の購入が完了しました。");
    }
}
