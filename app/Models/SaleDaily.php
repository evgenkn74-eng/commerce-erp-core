<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDaily extends Model
{
    public $timestamps = false;
	// явно указывает Eloquent, с какой таблицей в MySQL работать, отключая автоматическое правило множественного числа.
    protected $table = 'sales_daily';

    protected $fillable = ['product_id', 'sale_date', 'quantity', 'amount'];

    protected $casts = ['sale_date' => 'date'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
