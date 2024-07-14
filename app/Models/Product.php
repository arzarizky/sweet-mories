<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;

class Product extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
    ];
}
