<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rider()
    {
        return $this->hasOne(User::class, 'id', 'rider_id');
    }

}
