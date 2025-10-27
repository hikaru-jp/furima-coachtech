<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return view('items.index');
    }

    public function create()
    {
        return view('items.sell');
    }

    public function store(Request $request)
    {
        // 商品登録処理は後
        return redirect()->route('items.index')->with('success', '商品を登録しました。');
    }

    public function show($item_id)
    {
        return view('items.show', compact('item_id'));
    }

    public function favorite($item_id)
    {
        return back()->with('success', "商品（ID: {$item_id}）にいいねしました。");
    }

    public function comment(Request $request, $item_id)
    {
        return back()->with('success', 'コメントを投稿しました。');
    }

    public function destroy($item_id)
    {
        return redirect()
            ->route('items.index')
            ->with('success', "商品（ID: {$item_id}）を削除しました。");
    }
}
