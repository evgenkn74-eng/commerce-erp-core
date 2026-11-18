<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. Обычный GET-запрос (аналог вашего метода get)
// Route::get('/hello', function () {
//     return 'Привет, мир!';
// });

// 2. Обычный POST-запрос (аналог вашего метода post)
// Route::post('/submit', [PostController::class, 'store']);

// 3. Несколько методов на один адрес (аналог вашего универсального метода)
// Route::match(['get', 'post'], '/feedback', [PostController::class, 'feedback']);

// 4. Любой HTTP-метод (GET, POST, PUT, DELETE и т.д.)
// Route::any('/webhook', [PostController::class, 'webhook']);

// 5. Быстрый показ шаблона Blade без создания контроллера
// Откроет файл resources/views/about.blade.php
// Route::view('/about', 'about');

// 6. Редирект со старого адреса на новый (301 — постоянный)
// Route::redirect('/old-page', '/about', 301);

// 7. Динамический параметр в URL (необязательный параметр пишется со знаком ? — {id?})
// Route::get('/post/{id}', function (string $id) {
//     return "Пост номер: " . $id;
// });

// 8. Именованный маршрут (позволяет генерировать ссылку в шаблоне через route('contacts'))
// Route::get('/contacts', [PostController::class, 'contacts'])->name('contacts');

// 9. Группа маршрутов с общим префиксом URL (/admin/...)
// Route::prefix('admin')->group(function () {
//     Route::get('/users', function () { return 'Список пользователей'; }); // адрес: /admin/users
//     Route::get('/stats', function () { return 'Статистика'; });           // адрес: /admin/stats
// });

// 10. Готовый набор из 7 CRUD-маршрутов для контроллера (index, create, store, show, edit, update, destroy)
// Route::resource('articles', PostController::class);
