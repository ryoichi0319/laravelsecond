<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; // 追加


class Item extends Model
{
    use HasFactory;
    use Sortable;  // 追加


    protected $fillable = [
        'name',
        'quantity',
        'order_id',
        'status',
        'table_number',
        'price'

    ];
    public $sortable = [
    'order_id',
    'price',
    'created_at',
    'updated_at',
    'status'

   ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
