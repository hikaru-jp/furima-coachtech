<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 出品した商品（1人のユーザーは複数の商品を持つ）
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // コメント（1人のユーザーは複数コメントする）
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // いいね（1人のユーザーは複数いいねする）
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // 購入履歴（1人のユーザーが複数の商品を購入）
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // 住所（1人のユーザーに1つの住所）
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
