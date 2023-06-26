<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'order_id',
        'name',
        'address',
        'phone',
        'email',
        'area',
        'total',
        'schedule',
        'message',
        'proof_of_transfer'
    ];

    // relation to order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
