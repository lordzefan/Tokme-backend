<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'is_default',
        'receiver_name',
        'receiver_phone',
        'city_id',
        'district',
        'postal_code',
        'detail_address',
        'address_note',
        'type',
    ];
}
