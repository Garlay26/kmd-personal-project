<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllCustomer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'customers';

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
