<?php

namespace App\Models;


use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'yearlevel',
        'gender',
        'department',
        'studentnumber',
        'email',
        'password',
        'photo',
    ];
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($student) {
            $student->updateYearLevel();
        });
    }

    // Define the method to update the year level
    public function updateYearLevel()
    {
        $createdAt = Carbon::parse($this->created_at);
        $now = Carbon::now();
        $yearsPassed = $now->diffInYears($createdAt);

        // Check if yearlevel needs to be updated
        if ($yearsPassed > 0 && $this->yearlevel < 4) {
            $this->yearlevel = min($this->yearlevel + $yearsPassed, 4);
            $this->save(); // Persist the change
        }
    }
}
