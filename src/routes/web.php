<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MyPageController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 商品一覧
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');
Route::delete('/item/{item_id}', [ItemController::class, 'destroy'])->name('items.destroy');

//いいね機能
Route::middleware(['auth'])->group(function () {
    Route::post('/item/{item_id}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// コメント投稿
Route::middleware(['auth'])->group(function () {
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comments.store');
});

// 購入
Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::post('/purchase/{item_id}/checkout', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/{item_id}/after_stripe', [PurchaseController::class, 'afterStripe'])->name('purchase.after_stripe');
});

// 住所変更
Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit'])
    ->name('address.edit')
    ->middleware('auth');
Route::patch('/purchase/address/{item_id}', [AddressController::class, 'update'])
    ->name('address.update')
    ->middleware('auth');

// 商品出品
Route::middleware('auth')->group(function () {
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('mypage.profile');
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('mypage.update');
});
