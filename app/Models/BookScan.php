<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BookScan extends Model
{
        use HasFactory;

    protected $fillable = ['file_id', 'is_scanned', 'scan_path', 'scanned_at'];
}
