<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerReview extends Model
{
    protected $fillable = [
        'external_id', 'product_id', 'rating', 'text',
        'status', 'ai_draft', 'answered_at',
    ];
	// Указывает Laravel автоматически преобразовывать сырые данные из MySQL в удобные PHP-типы при чтении и обратно при записи
    protected $casts = [
        'rating' => 'integer',
        'answered_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
		// Это обратная связь «принадлежит к» (Many-to-One): каждый конкретный отзыв относится к одному товару
        return $this->belongsTo(Product::class);
    }
}
