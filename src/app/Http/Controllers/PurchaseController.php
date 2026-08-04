<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Address;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    /**
     * 購入画面を表示する。
     *
     * @param int $item_id
     * @return View
     */
    public function create(int $item_id): View
    {
        $item = Item::query()->findOrFail($item_id);

        $address = Address::query()
            ->where('user_id', Auth::id())
            ->where('item_id', $item_id)
            ->first();

        if (!$address) {
            $address = Auth::user()?->address;
        }

        return view('purchase.index', compact(
            'item',
            'address'
        ));
    }

    /**
     * 購入処理を行う。
     *
     * @param PurchaseRequest $request
     * @param int $item_id
     * @return RedirectResponse
     */
    public function store(
        PurchaseRequest $request,
        int $item_id
    ): RedirectResponse {
        $validated = $request->validated();

        DB::transaction(function () use (
            $item_id,
            $validated
        ): void {
            $item = Item::query()
                ->lockForUpdate()
                ->findOrFail($item_id);

            if ($item->is_sold) {
                abort(
                    409,
                    'この商品はすでに購入されています。'
                );
            }

            Purchase::query()->create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'payment_method' => $validated['payment_method'],
            ]);

            $item->update([
                'is_sold' => true,
            ]);
        });

        return redirect()
            ->route('items.index')
            ->with(
                'success',
                '商品を購入しました。'
            );
    }
}