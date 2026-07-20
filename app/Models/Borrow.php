<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

     protected $fillable = [
        'b_date',
        'b_no',
        'b_name',
        's_name',
        'r_date',
        'status'
    ];
}
