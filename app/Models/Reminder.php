<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
