<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function airlines()
    {
        return $this->hasMany(Airline::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }
}