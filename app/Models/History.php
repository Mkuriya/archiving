<?php

namespace App\Models;

use App\Models\File;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory;
    protected $table = 'history'; 
    protected $fillable = ['student_id', 'document_id'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function document()
    {
        return $this->belongsTo(File::class);
    }
}
