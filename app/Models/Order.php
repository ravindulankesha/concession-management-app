<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'send_to_kitchen_time',
        'status',
    ];

    public function concessions()
    {
        return $this->belongsToMany(Concession::class, 'concession_order');
    }
}
