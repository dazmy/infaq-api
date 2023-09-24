<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_name',
        'donation_amount_plus',
        'donation_amount_minus',
        'donation_date'
    ];
}
