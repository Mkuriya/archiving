<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Admin;
use App\Models\History;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OldView extends Controller
{
    public function showMenu(){
        $history = History::all(); // Retrieve all history records from the database

        return view('archive.history', ['history' => $history]);
    }


    public function archivelistfilter(Request $request) {
        // Create an initial query
        $query = File::query();

        // Apply search filter
        if ($searchTerm = $request->input('search')) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('year', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply year filter
        if ($year = $request->input('year')) {
            $query->where('year', $year);
        }

        // Apply student department filter
        if ($studentDepartment = $request->input('student_department')) {
            $query->where('student_department', $studentDepartment);
        }

        // Get the results, order by title and paginate
        $files = $query->orderBy('title', 'asc')->paginate(7)->appends($request->except('page'));

        // Fetch all history records
        $history = History::all();

        // Return the filtered view with the files and history data
        return view('archive.studentarchivefilter', compact('files', 'history'));
    }





    public function studentArchiveList(Request $request) {
        $query = File::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('year', 'LIKE', "%{$search}%")
                  ->orWhere('abstract', 'LIKE', "%{$search}%");
            });
        }

        if ($request->input('status') == 0) {
            $query->where('status', 1);
        }

        // Add sorting
        $query->orderBy('title', 'asc'); // or 'year', 'student->firstname', etc.

        // Paginate and append query parameters except 'page'
        $files = $query->paginate(7)->appends($request->except('page'));
        $history = History::all();
        return view('archive.archivelist', compact('files'), ['history' => $history]);
    }

      public function viewDocument(File $file){

        return view('archive.view', ['file' => $file ]);
    }
    public function historyDoc(File $file){

        // Fetch history if you need it for the view
        $history = History::all();

        return view('archive.viewer', ['file' => $file, 'history' => $history]);
    }
    public function viewDoc(File $file){
        $userId = auth()->guard('student')->id(); // Get the authenticated user's ID
        $fileId = $file->id;

        // Save the history record
        \App\Models\History::create([
            'student_id' => $userId,
            'document_id' => $fileId,
        ]);

        // Fetch history if you need it for the view
        $history = History::all();

        return view('archive.viewer', ['file' => $file, 'history' => $history]);
    }


    public function adminPassword(Admin $admin){
        return view('admin.changepassword', ['admin' => $admin]);
    }



    public function studentprofileView(Student $student){
        $history = History::all();
        return view('accounts.studentprofile', ['student' => $student,'history' => $history]);
    }
    public function adminprofileView(Admin $admin){
        return view('accounts.adminprofile', ['admin' => $admin]);
    }

    public function studentEdit(Student $student){
        return view('accounts.editstudent', ['student' => $student]);
    }
    public function studentView(Student $student){
        return view('accounts.viewstudent', ['student' => $student]);
    }
    public function filterstudentlist(Request $request){
        $query = Student::query();

        // Apply search filter
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $query->where(function($query) use ($searchTerm) {
                $query->where('lastname', 'like', '%' . $searchTerm . '%')
                      ->orWhere('firstname', 'like', '%' . $searchTerm . '%')
                      ->orWhere('middlename', 'like', '%' . $searchTerm . '%')
                      ->orWhere('studentnumber', 'like', '%' . $searchTerm . '%');
            });
        }
        // Apply gender filter
        if ($request->has('gender') && !empty($request->input('gender'))) {
            $query->where('gender', $request->input('gender'));
        }

        // Apply department filter
        if ($request->has('department') && !empty($request->input('department'))) {
            $query->where('department', $request->input('department'));
        }

        $students = $query->orderBy('lastname', 'asc')->paginate(7)->appends($request->except('page'));
        return view('accounts.filterstudentlist', compact('students'));
    }
    public function studentlist(Request $request){
        $query = Student::query();

        $students = $query->orderBy('lastname', 'asc')->paginate(7)->appends($request->except('page'));
        return view('accounts.studentlist', compact('students'));
    }

    //for admin
    public function adminReset(){
        return view('accounts.resetadmin');
    }

    public function adminDashboard(){
        $totalUpload = File::where('status', 1)->count();
        $totalPending = File::where('status', 0)->count();

        $totalStudent = Student::count();
        return view('admin.dashboard',compact('totalUpload', 'totalStudent', 'totalPending' ));
    }
    public function register(){
        return view('admin.register');
    }
    public function adminLogin(){
        return view('admin.login');
    }
    public function adminDashboardStudent(){
        return view('student.register');
    }
    public function adminlist(Request $request){
        $query = Admin::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'LIKE', "%{$search}%")
                  ->orWhere('lastname', 'LIKE', "%{$search}%")
                  ->orWhere('middlename', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Hide a specific account by its ID (e.g., ID = 123)
        $query->whereNotIn('id', [1, Auth::id()]); // Adjust 'id' to match your database schema

        // Paginate
        $admins = $query->orderBy('lastname', 'asc')->paginate(7)->appends($request->except('page'));

        return view('accounts.adminlist', compact('admins'));
    }
    public function adminEdit(Admin $admin){
        return view('accounts.editadmin', ['admin' => $admin]);
    }
    public function adminView(Admin $admin){
        return view('accounts.viewadmin', ['admin' => $admin]);
    }

    public function index()
    {
        return view('admin.login');
    }
}
