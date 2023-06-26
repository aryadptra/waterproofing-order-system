<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'user_id',
        'service_id',
        'status'
    ];

    // relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relation to service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // relation to order detail
    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class);
    }
}
