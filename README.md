sail artisan breeze:install react

api認証
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // コメントアウト状態だったらコメントアウトを外す、なかったら書き足す

config  cors    'supports_credentials' => true, // falseだったらtrueに変更
