<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    use HasFactory;

    public $fillable = ['title', 'price', 'description', 'servicetype', 'image_path', 'image_path2'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
