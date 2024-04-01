<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}