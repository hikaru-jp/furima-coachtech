<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MyPageController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;

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

// 商品一覧画面（トップ画面）
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品一覧画面（トップ画面) _マイリスト
Route::get('/?tab=mylist', [ItemController::class, 'mylist'])->name('items.mylist');

// 商品詳細画面
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');
Route::post('/item/{item_id}/favorite', [ItemController::class, 'favorite'])->name('items.favorite');
Route::post('/item/{item_id}/comment', [ItemController::class, 'comment'])->name('items.comment');
Route::delete('/item/{item_id}', [ItemController::class, 'destroy'])->name('items.destroy');

// 購入確認画面
Route::get('/purchase/{item_id}', [PurchaseController::class, 'confirm'])->name('purchase.confirm');
Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');

// 住所変更ページ
Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit'])
    ->name('address.edit')
    ->middleware('auth');
Route::post('/purchase/address/{item_id}', [AddressController::class, 'update'])
    ->name('address.update')
    ->middleware('auth');

// 商品出品画面
Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
Route::post('/sell', [ItemController::class, 'store'])->name('items.store');

// プロフィール画面
Route::middleware(['auth'])->group(function () {
    // プロフィールトップ（プロフィール＋タブ）
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');

    // 出品一覧
    Route::get('/mypage/sold', [MyPageController::class, 'soldItems'])->name('mypage.sold');

    // 購入一覧
    Route::get('/mypage/purchased', [MyPageController::class, 'purchasedItems'])->name('mypage.purchased');

    // プロフィール編集
    Route::get('/mypage/profile', [MyPageController::class, 'edit'])->name('mypage.edit');
    Route::post('/mypage/profile', [MyPageController::class, 'update'])->name('mypage.update');
});

// プロフィール初回設定（初回ログイン時用）
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'update'])->name('profile.update');
});
