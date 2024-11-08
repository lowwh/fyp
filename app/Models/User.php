<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'age',
        'gender',
        'image_path',
        'state',
        'language',
        'serviceType',
        'freelancer_id',
        'total_earn'
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

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }


    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function unreadBiddingNotifications()
    {

        return $this->notifications()->whereNull('read_at')->where('type', 'App\Notifications\BidPlacedNotification');
    }


    public function unreadBiddingSuccessNotifications()
    {

        return $this->notifications()->whereNull('read_at')->where('type', 'App\Notifications\BiddingSuccessNotification');
    }


    public function unreadNotifications()
    {

        return $this->notifications()->whereNull('read_at')->where('type', 'App\Notifications\NewMessageNotification');
    }


    public function unreadRejectNotifications()
    {

        return $this->notifications()->whereNull('read_at')->where('type', 'App\Notifications\ServiceRejectedNotification');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


}