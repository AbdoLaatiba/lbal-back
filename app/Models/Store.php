<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'store_city',
        'store_description',
        'bank_account_details',
        'user_id',
    ];

    protected $casts = [
        'bank_account_details' => 'array',
    ];
}
