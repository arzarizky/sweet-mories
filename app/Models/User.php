<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\UUIDAsPrimaryKey;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UUIDAsPrimaryKey;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'promo_id',
        'google_id',
        'google_token',
        'google_refresh_token',
        'role_id',
        'no_tlp',
        'avatar',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(): HasOne
    {
        return $this->HasOne(Role::class, 'id', 'role_id');
    }

    public function isAdmin() {
        return $this->role->name == "Admin";
    }

    public function isClient() {
        return $this->role->name == "Client";
    }

    public function getPicAvatarAdmin()
    {
        $url = url($this->avatar);
        $parsedUrl = parse_url($url);

        if (isset($parsedUrl['scheme']) && $parsedUrl['scheme'] === 'https') {
            return $url;
        } else {
            return url('images/picture/avatar/'.$this->avatar);
        }
    }

    public function bookings()
    {
        return $this->belongsTo(Booking::class, 'user_id', 'id');
    }

    public function invoices()
    {
        return $this->belongsTo(Invoice::class, 'user_id', 'id');
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'promo_id', 'id');
    }
}
