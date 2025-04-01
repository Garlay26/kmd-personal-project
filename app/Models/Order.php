<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    
    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function deliveryTime()
    {
        return $this->belongsTo(DeliveryTime::class);
    }
}
