<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\UUIDAsPrimaryKey;

class OutletSetting extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $fillable = ['name', 'start_day', 'start_time', 'end_day', 'end_time', 'is_active'];
}

