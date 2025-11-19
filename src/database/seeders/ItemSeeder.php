<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani%20Mens%20Clock.jpg',
                'condition' => '良好',
                'categories' => ['アクセサリー', 'ファッション'],
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD%20Hard%20Disk.jpg',
                'condition' => '目立った傷や汚れなし',
                'categories' => ['家電'],
            ],
            [
                'name' => '玉ねぎ3袋',
                'price' => 300,
                'brand' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG%20d.jpg',
                'condition' => 'やや傷や汚れあり',
                'categories' => ['キッチン'],
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'brand' => null,
                'description' => 'クラシックなデザインの革靴',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather%20Shoes%20Product%20Photo.jpg',
                'condition' => '状態が悪い',
                'categories' => ['ファッション'],
            ],
            [
                'name' => 'ノートPC',
                'price' => 48000,
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living%20Room%20Laptop.jpg',
                'condition' => '良好',
                'categories' => ['家電'],
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'brand' => null,
                'description' => '高音質のレコーディング用マイク',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music%20Mic%204632231.jpg',
                'condition' => '目立った傷や汚れなし',
                'categories' => ['家電'],
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse%20fashion%20pocket.jpg',
                'condition' => 'やや傷や汚れあり',
                'categories' => ['ファッション'],
            ],
            [
                'name' => 'タンブラー',
                'price' => 800,
                'brand' => null,
                'description' => '使いやすいタンブラー',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler%20souvenir.jpg',
                'condition' => '状態が悪い',
                'categories' => ['キッチン'],
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress%20with%20Coffee%20Grinder.jpg',
                'condition' => '良好',
                'categories' => ['キッチン', 'インテリア'],
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'condition' => '目立った傷や汚れなし',
                'categories' => ['コスメ'],
            ],
        ];

        foreach ($items as $data) {
            $item = Item::create([
                'user_id' => 1,
                'name' => $data['name'],
                'brand' => $data['brand'],
                'description' => $data['description'],
                'price' => $data['price'],
                'condition' => $data['condition'],
                'img_url' => $data['img_url'],
            ]);

            $categoryIds = \App\Models\Category::whereIn('name', $data['categories'])->pluck('id');
            $item->categories()->attach($categoryIds);
        }
    }
}
