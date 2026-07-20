<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructorbook extends Model
{
    use HasFactory;
    protected $fillable = [
            'instructor_id',
            'file_id',
        ];


}
