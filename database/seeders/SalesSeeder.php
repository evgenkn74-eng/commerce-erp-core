<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SalesSeeder extends Seeder
{
	// Продажи за 60 дней на каждый товар, 3000 × 60 = 180 000 строк.
	// У каждого товара своя популярность, чтобы средние продажи в день были разными.
	// Для экономии памяти накапливаем массив и сбрасываем его в базу каждые 1000 строк

	// В sales_daily нет меток created_at и updated_at, поэтому здесь их не добавляем.
	// Пара product_id + sale_date уникальна, повторный запуск сидера без migrate:fresh падает на дубликатах,
	// и это хорошо, это защита
    private const DAYS = 60;
    private const CHUNK_SIZE = 1000;

    public function run(): void
    {
        DB::disableQueryLog();

        $today = Carbon::today();
        $products = DB::table('products')->select('id', 'price')->get();
        $buffer = [];

        foreach ($products as $product) {
            // средняя популярность товара: от 0 до 20 продаж в день
            $popularity = random_int(0, 20);

            for ($d = 0; $d < self::DAYS; $d++) {
                $quantity = $popularity === 0 ? 0 : random_int(0, $popularity * 2);
                $buffer[] = [
                    'product_id' => $product->id,
                    'sale_date' => $today->copy()->subDays($d)->toDateString(),
                    'quantity' => $quantity,
                    'amount' => $quantity * (float) $product->price,
                ];

                if (count($buffer) >= self::CHUNK_SIZE) {
                    DB::table('sales_daily')->insert($buffer);
                    $buffer = [];
                }
            }
        }

        if ($buffer !== []) {
            DB::table('sales_daily')->insert($buffer);
        }
    }
}
