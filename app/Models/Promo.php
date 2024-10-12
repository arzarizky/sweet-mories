<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;

class Promo extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $table = 'promo';

    protected $fillable = [
        'name',
        'code',
        'discount_value',
        'discount_percentage',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'model',
        'is_active',
    ];
}
