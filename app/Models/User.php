<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use Stripe\SetupIntent;
use Illuminate\Database\Eloquent\Casts\Attribute;//追加

class User extends Authenticatable
{
    use Billable, HasApiTokens, HasFactory, Notifiable;

    public function createSetupIntent(array $options = []): SetupIntent
    {
        // Stripe API キーを設定する
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        // Stripe の SetupIntent を作成する
        return SetupIntent::create($options);
    }

    public function posts(){
        return $this->hasMany((Post::class));
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'trial_ends_at',
        'google2fa_secret',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret'

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // 他のモデルとの関連（例：注文との関連）
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function onTrial($type = 'default', $price = null)
    {
        // 例として、trial_ends_at カラムが現在日時よりも後の場合はトライアル中と見なす
        return $this->trial_ends_at > now();
    }

    /**
     * Get the trial end date for the user.
     *
     * @return \DateTime|null
     */
    public function trialEndsAt($type="default")
    {
        // trial_ends_at カラムの値を返す
        return $this->trial_ends_at;
    }
    

     /**
     * ここから追加
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function google2faSecret(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  decrypt($value),
            set: fn ($value) =>  encrypt($value),
        );
    }

}
