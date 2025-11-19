<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_method' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'payment_method' => '支払い方法',
        ];
    }
}
