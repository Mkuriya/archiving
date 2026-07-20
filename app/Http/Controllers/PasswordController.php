<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    public function passwordReset($token, Request $request){
        $email = $request->query('email');
        return view('accounts.new-password', compact('token', 'email'));
    }
    
    public function reset_password(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);
    
        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();
    
        if(!$updatePassword){
            return redirect()->route('password_reset', ['token' => $request->token, 'email' => $request->email])
                             ->withErrors(['email' => 'Invalid token or email. Please request a new password reset.']);
        }
    
        $userType = null;
    
        // Check and update the password in the students table
        $student = Student::where('email', $request->email)->first();
        if($student){
            $student->update([
                'password' => Hash::make($request->password),
            ]);
            $userType = 'student';
        } else {
            // Check and update the password in the admins table
            $admin = Admin::where('email', $request->email)->first();
            if($admin){
                $admin->update([
                    'password' => Hash::make($request->password),
                ]);
                $userType = 'admin';
            } else {
                return redirect()->route('password_reset', ['token' => $request->token, 'email' => $request->email])
                                 ->withErrors(['email' => 'User not found.']);
            }
        }
    
        DB::table('password_resets')->where(['email' => $request->email])->delete();
    
        if($userType == 'student'){
            return redirect('/student/login')->with('success', 'Your password has been successfully reset.');
        } else {
            return redirect('/admin/login')->with('success', 'Your password has been successfully reset.');
        }
    }
    
    
    public function forget_password_post(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $emailExistsInStudents = Student::where('email', $request->email)->exists();
        $emailExistsInAdmins = Admin::where('email', $request->email)->exists();
    
        if(!$emailExistsInStudents && !$emailExistsInAdmins){
            return redirect()->back()->withErrors(['email' => 'Email does not exist in our records.']);
        }
    
        $token = Str::random(64);
    
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    
        Mail::send('accounts.resetpassword', ['token' => $token, 'email' => $request->email], function($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password");
        });
    
        return redirect()->back()->with('success', 'A reset password link has been sent to your registered email address');
    }
}
