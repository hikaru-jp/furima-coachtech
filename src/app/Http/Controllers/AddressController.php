<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function edit($item_id)
    {
        $address = Address::where('user_id', Auth::id())->where('item_id', $item_id)->first();
        return view('address.update', [
            'address' => $address,
            'item_id' => $item_id,
        ]);
    }

    // 住所更新処理
    public function update(AddressRequest $request, $item_id)
    {
        $item_id = (int) preg_replace('/[^0-9]/', '', $request->item_id ?? $item_id);

        $address = Address::where('user_id', Auth::id())->where('item_id', $item_id)->first();

        if ($address) {
            $address->update([
                'postal_code' => $request->postal_code,
                'address_line' => $request->address_line,
                'building_name' => $request->building_name,
            ]);
        } else {
            Address::create([
                'user_id' => Auth::id(),
                'item_id' => $item_id,
                'postal_code' => $request->postal_code,
                'address_line' => $request->address_line,
                'building_name' => $request->building_name,
            ]);
        }
        return redirect()->route('purchase.create', ['item_id' => $item_id]);
    }
}
