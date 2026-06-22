<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'user_id' => 1,
                'condition_id' => 1,
                'category_ids' => [1, 5, 12],
                'name' => '腕時計',
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            ],

            [
                'user_id' => 1,
                'condition_id' => 2,
                'category_ids' => [2],
                'name' => 'HDD',
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            ],

            [
                'user_id' => 1,
                'condition_id' => 3,
                'category_ids' => [10],
                'name' => '玉ねぎ3束',
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => 300,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            ],

            [
                'user_id' => 1,
                'condition_id' => 4,
                'category_ids' => [1, 5],
                'name' => '革靴',
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            ],
            [
                'user_id' => 1,
                'condition_id' => 1,
                'category_ids' => [2],
                'name' => 'ノートPC',
                'brand' => ' ',
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg'
            ],
            [
                'user_id' => 1,
                'condition_id' => 2,
                'category_ids' => [2],
                'name' => 'マイク',
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            ],
            [
                'user_id' => 1,
                'condition_id' => 3,
                'category_ids' => [1, 4],
                'name' => 'ショルダーバッグ',
                'brand' => ' ',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            ],
            [
                'user_id' => 1,
                'condition_id' => 4,
                'category_ids' => [10],
                'name' => 'タンブラー',
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            ],
            [
                'user_id' => 1,
                'condition_id' => 1,
                'category_ids' => [10],
                'name' => 'コーヒーミル',
                'brand' => 'Starbacks',
                'description' => '主導のコーヒーミル',
                'price' => 4000,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            ],
            [
                'user_id' => 1,
                'condition_id' => 2,
                'category_ids' => [6],
                'name' => 'メイクセット',
                'brand' => ' ',
                'description' => '便利なメイクアップセット',
                'price' => 2500,
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            ],
        ];

        foreach ($items as $item) {
            $categoryIds = $item['category_ids'];

            unset($item['category_ids']);

            $createdItem = Item::create($item);

            $createdItem->categories()->attach($categoryIds);
        }
    }
}