<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CatalogSeeder extends Seeder
{
	// Категории, склады, товары и остатки. Остатки генерируем с разбросом: у части товаров мало, у части много,
	// чтобы в аналитике появились все три статуса: дефицит, норма, неликвид

	// Здесь DB::table()->insert() вместо Model::insert():
	// оба дают один и тот же пакетный INSERT, но без лишней обёртки Eloquent.
    private const PRODUCTS_COUNT = 3000;
    private const CHUNK_SIZE = 1000;

    public function run(): void
    {
		// Два момента про память и скорость: перед массовой вставкой отключаем лог запросов (DB::disableQueryLog()),
		// иначе Laravel будет держать в памяти текст каждого запроса.
		// И ставим один вызов Carbon::now() на весь сидер, а не на каждую строку
        DB::disableQueryLog();
        $now = Carbon::now();

        $categories = ['Электроника', 'Одежда', 'Обувь', 'Дом и сад', 'Красота', 'Детские товары', 'Спорт', 'Автотовары'];
        $warehouses = ['Москва', 'Казань', 'Новосибирск', 'Краснодар'];

        DB::table('categories')->insert(array_map(
            fn (string $name): array => ['name' => $name, 'created_at' => $now, 'updated_at' => $now],
            $categories,
        ));
        DB::table('warehouses')->insert(array_map(
            fn (string $name): array => ['name' => $name, 'created_at' => $now, 'updated_at' => $now],
            $warehouses,
        ));

        $categoryIds = DB::table('categories')->pluck('id')->all();
        $warehouseIds = DB::table('warehouses')->pluck('id')->all();

        $products = [];
        for ($i = 1; $i <= self::PRODUCTS_COUNT; $i++) {
            $products[] = [
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'sku' => sprintf('SKU-%06d', $i),
                'name' => 'Товар №' . $i,
                'price' => random_int(99, 15000),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        foreach (array_chunk($products, self::CHUNK_SIZE) as $chunk) {
            DB::table('products')->insert($chunk);
        }

        $productIds = DB::table('products')->pluck('id')->all();
        $stocks = [];
        foreach ($productIds as $productId) {
            // у товара есть типовой объём остатка: мало, средне или много
            $scale = [5, 60, 600][random_int(0, 2)];
            foreach ($warehouseIds as $warehouseId) {
                $stocks[] = [
                    'product_id' => $productId,
                    'warehouse_id' => $warehouseId,
                    'quantity' => random_int(0, $scale),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        foreach (array_chunk($stocks, self::CHUNK_SIZE) as $chunk) {
            DB::table('product_stocks')->insert($chunk);
        }
    }
}
