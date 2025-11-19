<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => 1,
            'postal_code' => '123-4567',
            'address_line' => 'テスト市テスト町',
            'building_name' => 'テストビル',
            'item_id' => null,
        ];
    }
}
