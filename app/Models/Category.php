<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
	// Это «белый список» полей для массового заполнения в БД
    protected $fillable = ['name'];
	// «черный список» запрещенных полей (всё остальное разрешено)
	// protected $guarded = ['id'];

	// Это объявление связи «один ко многим» (One-to-Many): одна категория содержит много товаров
    public function products(): HasMany
    {
		// Метод $this->hasMany(Product::class) возвращает специальный объект-построитель связи
		// (обёртку над SQL-запросом SELECT * FROM products WHERE category_id = ?),
		// чтобы вы могли легко получать, фильтровать или создавать товары этой категории без ручного написания JOIN и WHERE
        return $this->hasMany(Product::class);
    }
}
