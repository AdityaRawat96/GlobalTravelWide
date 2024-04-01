<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function queries()
    {
        return $this->hasMany(Query::class);
    }
}
