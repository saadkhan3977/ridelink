<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rider()
    {
        return $this->hasOne(User::class, 'id', 'rider_id');
    }
    
    public function ride()
    {
        return $this->hasMany(User::class, 'id', 'rider_id');
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    public function carinfo()
    {
        return $this->hasOne(Car::class, 'id', 'car_id');
    }
}
