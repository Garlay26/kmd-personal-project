<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('is_delete', function (Builder $builder) {
            $builder->where('is_delete',0);
        });
    }
}
