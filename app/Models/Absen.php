<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absen extends Model
{

    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'check_in',
        'check_in_location',
        'check_in_address',
        'status',
    ];
}
