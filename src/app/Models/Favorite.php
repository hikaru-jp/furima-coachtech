<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
    ];

    // いいねしたユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 対象の商品
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
