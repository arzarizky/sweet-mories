<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;


class Booking extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $table = 'bookings';

    public function userBook(): HasMany
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
