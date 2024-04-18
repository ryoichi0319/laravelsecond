sail artisan breeze:install react

api認証
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // コメントアウト状態だったらコメントアウトを外す、なかったら書き足す

config  cors    'supports_credentials' => true, // falseだったらtrueに変更

stripe
public apikeyとsecret apikey 
config/stripe.php

- これでわかる基礎からのlaravel reffect cashier subscription
レイアウトファイルであるresouces¥views¥layous¥app.blade.phpファイルのbodyの閉じタグの手前に@stack(‘scripts’)を追加します。

フォームの外側のcard-elementにCSSを適用することでborderを表示させましたがフォーム内部の要素にCSSを適用したい場合は、elements.create(‘card’)の第二引数にオプションとしてstyle、classを設定することでできます。

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

スケジュール app/console
sail artisan schedule:work

sort
config.app.phpにサービスプロバイダ、エイリアスを追加する
