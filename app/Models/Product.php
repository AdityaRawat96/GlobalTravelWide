<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
