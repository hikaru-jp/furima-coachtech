<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
        'image_path',
        'status',
    ];

    // 出品者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // カテゴリー
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // コメント
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // いいね
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // 購入履歴
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
