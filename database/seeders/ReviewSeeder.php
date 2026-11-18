<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ReviewSeeder extends Seeder
{
	// Отзывы с разными рейтингами и статусами. Большинство new, чтобы была очередь для оператора, часть уже sent.
	// Рейтинги смещены к высоким, но негативных тоже достаточно
    private const REVIEWS_COUNT = 5000;
    private const CHUNK_SIZE = 1000;

    private const TEXTS = [
        1 => 'Ужасно, товар пришёл сломанным.',
        2 => 'Качество хуже, чем ожидал.',
        3 => 'Нормально, но есть замечания.',
        4 => 'Хороший товар, рекомендую.',
        5 => 'Отлично, всё подошло!',
    ];

    public function run(): void
    {
        DB::disableQueryLog();
        $now = Carbon::now();

        $productIds = DB::table('products')->pluck('id')->all();
        $ratings = [1, 1, 2, 2, 3, 3, 4, 4, 4, 5, 5, 5, 5, 5];
        $buffer = [];

        for ($i = 1; $i <= self::REVIEWS_COUNT; $i++) {
            $rating = $ratings[array_rand($ratings)];
            $createdAt = $now->copy()->subMinutes(random_int(0, 60 * 24 * 30));
            $isSent = random_int(1, 100) <= 30;

            $buffer[] = [
                'external_id' => 'WB-' . str_pad((string) $i, 8, '0', STR_PAD_LEFT),
                'product_id' => $productIds[array_rand($productIds)],
                'rating' => $rating,
                'text' => self::TEXTS[$rating],
                'status' => $isSent ? 'sent' : 'new',
                'ai_draft' => null,
                'answered_at' => $isSent ? $createdAt->copy()->addHours(2) : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            if (count($buffer) >= self::CHUNK_SIZE) {
                DB::table('customer_reviews')->insert($buffer);
                $buffer = [];
            }
        }

        if ($buffer !== []) {
            DB::table('customer_reviews')->insert($buffer);
        }
    }
}
