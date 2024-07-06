<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    use HasFactory;
    protected $fillable = [

        'expectation',
        'reason',
        'suggestion',
        'rating',
        'result_id'
    ];

    public $timestamps = false;

    public function result()
    {
        return $this->belongsTo(Result::class);
    }
}
