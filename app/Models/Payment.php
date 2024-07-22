<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = ['user_id', 'invoice_id', 'payment_method', 'payment_status'];



    public function user()
    {

        return $this->belongsTo(User::class);
    }



    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
