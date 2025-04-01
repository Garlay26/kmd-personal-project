<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function township()
    {
        return $this->hasMany(Township::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
