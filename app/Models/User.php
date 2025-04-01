<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Branch;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = "users";
    protected $guard_name = 'web';
    
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'address',
        'branch_id',
        'points',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function branch_name(){
        return $this->belongsTo(Branch::class);
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
}
