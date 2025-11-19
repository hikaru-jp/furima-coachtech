<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Address;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class PurchaseController extends Controller
{
    public function create($item_id)
    {
        $item = Item::findOrFail((int) $item_id);

        $address = Address::where('user_id', Auth::id())->where('item_id', $item_id)->first();

        if (!$address) {
            $address = Auth::user()->address;
        }

        return view('purchase.index', compact('item', 'address'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item_id = (int) $item_id;
        $item = Item::findOrFail($item_id);

        if ($item->is_sold) {
            return redirect()->route('items.show', $item_id);
        }

        $address = Address::where('user_id', Auth::id())->where('item_id', $item_id)->first();

        if (!$address) {
            $base = Auth::user()->address;

            $address = Address::create([
                'user_id' => Auth::id(),
                'item_id' => $item_id,
                'postal_code' => $base->postal_code,
                'address_line' => $base->address_line,
                'building_name' => $base->building_name,
            ]);
        }

        if ($request->filled('postal_code') && $request->filled('address_line')) {
            $address->update([
                'postal_code' => $request->postal_code,
                'address_line' => $request->address_line,
                'building_name' => $request->building_name,
            ]);
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item_id,
            'payment_method' => $request->payment_method,
        ]);

        $item->is_sold = true;
        $item->save();

        return redirect()->route('items.index');
    }
    public function checkout($item_id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $item = \App\Models\Item::findOrFail($item_id);

        $checkout_session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('purchase.after_stripe', ['item_id' => $item->id]),
            'cancel_url' => route('purchase.create', ['item_id' => $item->id]),
        ]);

        return redirect($checkout_session->url);
    }
    public function afterStripe($item_id)
    {
        $item_id = (int) $item_id;

        $item = Item::findOrFail($item_id);

        if ($item->is_sold) {
            return redirect()->route('items.show', $item_id);
        }

        $request = new \Illuminate\Http\Request([
            'payment_method' => 'credit',
        ]);

        return $this->store($request, $item_id);
    }
}
