<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_category',
        'quantity',
        'condition',
        'donor_name',
        'donor_email',
        'donor_phone',
        'needs_pickup',
        'pickup_address',
        'notes',
        'status'
    ];
}
