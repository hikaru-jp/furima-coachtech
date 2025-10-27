<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function edit($item_id)
    {
        $address = Address::where('user_id', Auth::id())->first();
        return view('purchase.address', compact('address', 'item_id'));
    }

    public function update(Request $request, $item_id)
    {
        $address = Address::where('user_id', Auth::id())->first();

        if ($address) {
            $address->update([
                'postal_code' => $request->postal_code,
                'prefecture' => $request->prefecture,
                'city' => $request->city,
                'address_line' => $request->address_line,
                'building_name' => $request->building_name,
                'phone_number' => $request->phone_number,
            ]);
        } else {
            Address::create([
                'user_id' => Auth::id(),
                'postal_code' => $request->postal_code,
                'prefecture' => $request->prefecture,
                'city' => $request->city,
                'address_line' => $request->address_line,
                'building_name' => $request->building_name,
                'phone_number' => $request->phone_number,
            ]);
        }

        // 更新後、購入確認画面へ戻る
        return redirect()
            ->route('purchase.confirm', ['item_id' => $item_id])
            ->with('success', '住所を更新しました。');
    }
}
