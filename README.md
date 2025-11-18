# フリマアプリ

## ER 図

![ER図](./furima_ERdiagram.png)

# 環境構築

## Docker ビルド

- `git clone https://github.com/hikaru-jp/furima-coachtech.git`
- `docker-compose up -d --build`

## Laravel 初期設定

- `docker-compose exec php bash`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`

## 開発環境

- 会員登録：http://localhost/register
- 商品一覧：http://localhost/

# 使用技術（実行環境）

- PHP 8.1
- Laravel 8.83.8
- MySQL 8.0.26
