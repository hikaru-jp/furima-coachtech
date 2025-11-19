<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Purchase;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->tab ?? 'recommend';

        if ($tab === 'mylist') {
            return $this->mylist($request, $tab);
        }

        $query = Item::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        $items = $query->get();

        $myPurchasedItemIds = Purchase::where('user_id', auth()->id())
            ->pluck('item_id')
            ->toArray();

        return view('items.index', compact('items', 'tab', 'myPurchasedItemIds'));
    }

    private function mylist(Request $request, $tab)
    {
        $user = auth()->user();

        if (!$user) {
            return view('items.index', [
                'items' => collect(),
                'tab' => $tab,
                'myPurchasedItemIds' => [],
            ]);
        }

        $favoriteItemIds = $user->favorites()->pluck('item_id');

        $query = Item::whereIn('id', $favoriteItemIds);

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $items = $query->get();

        $myPurchasedItemIds = Purchase::where('user_id', auth()->id())
            ->pluck('item_id')
            ->toArray();
        return view('items.index', [
            'items' => $items,
            'tab' => $tab,
            'myPurchasedItemIds' => $myPurchasedItemIds,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        \Log::info('storeメソッド到達');

        $imgUrl = null;
        if ($request->hasFile('item_image')) {
            $imgUrl = $request->file('item_image')->store('items', 'public');
        }

        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'img_url' => $imgUrl,
        ]);

        $item->categories()->sync($request->categories ?? []);

        return redirect()->route('items.index');
    }

    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('items.show', compact('item'));
    }
}
