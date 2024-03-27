<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
         'status',
         'total_amount',
         'user_id',
         'table_number'
    ];


    // 注文と顧客のリレーション
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    // 注文と商品のリレーション
    public function items()
    {
        return $this->hasMany(Item::class);
    }


}
