<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logbook extends Model
{
    use HasFactory;
      protected $fillable = [
        'date',
        'b_no',
        'b_name',
        's_name'
    ];
}
