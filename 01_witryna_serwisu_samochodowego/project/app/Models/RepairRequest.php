<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairRequest extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ["clientID", "title", "model", "description"];

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Order::class, 'requestID');
    }
}

