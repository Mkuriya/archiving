<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Borrow;
use App\Models\File;
use App\Models\History;
use App\Models\Instructor;
use App\Models\Instructorbook;
use App\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ViewController extends Controller
{


   public function instructorlist(Request $request)
{
    $search = $request->search;

    $instructors = Instructor::orderBy('name')->get();
    $books = File::orderBy('book_number')->get();

    $query = Instructorbook::with(['instructor', 'file']);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('instructor', function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('file', function ($sub) use ($search) {
                $sub->where('book_number', 'like', "%{$search}%");
            });
        });
    }

    $grouped = $query->latest()
                    ->get()
                    ->groupBy('instructor_id');

    $page = request()->get('page', 1);
    $perPage = 10;

    $items = $grouped->slice(
        ($page - 1) * $perPage,
        $perPage
    );

    $assignments = new LengthAwarePaginator(
        $items,
        $grouped->count(),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query(),
        ]
    );

    return view('books.instructorlist', compact(
        'instructors',
        'books',
        'assignments'
    ));
    }
    public function instructor()
    {
        $instructors = Instructor::orderBy('name')->get();

        $books = File::orderBy('book_number')->get();
        $recentUpload = Instructorbook::with('file')->latest()->first();

        return view('books.create_instructor', compact(
            'instructors',
            'books',
            'recentUpload'
        ));
    }
    public function b_list()
    {
        $borrows = Borrow::orderBy('status', 'asc')
                        ->orderBy('b_date', 'desc')
                        ->get();

        return view('archive.b_list', compact('borrows'));
    }
    public function borrow(){
        return view('books.borrow');
    }

    public function getBook($book_number){
        $book = File::where('book_number', $book_number)->first();

        if ($book) {
            return response()->json([
                'title' => $book->title
            ]);
        }

        return response()->json([
            'title' => null
        ]);
    }

    public function print(){
        $files = File::where('status', 1)
                    ->orderBy('book_number', 'asc')
                    ->get();

        return view('admin.print', compact('files'));
    }

    public function fileSearch() {

        return view('archive.search');
    }
    public function searchFile(Request $request)
    {
        $query = $request->search;

        $files = File::where('status', 1)
            ->where(function($q) use ($query) {

                $q->where('title', 'LIKE', "%{$query}%")
                ->orWhere('abstract', 'LIKE', "%{$query}%")
                ->orWhere('department', 'LIKE', "%{$query}%")
                ->orWhere('year', 'LIKE', "%{$query}%")
                ->orWhere('members', 'LIKE', "%{$query}%")
                ->orWhere('book_number', 'LIKE', "%{$query}%")
                ->orWhere('adviser', 'LIKE', "%{$query}%");

            })
            ->get();

        return response()->json($files);
    }


    public function details($id)
    {
        $file = File::findOrFail($id);

        return view('archive.viewdetails', compact('file'));
    }
    public function viewDetails($id)
    {
        $file = File::findOrFail($id);

        return view('archive.details', compact('file'));
    }
    public function decline(Request $request){
        $query = File::query();

        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('book_number', 'LIKE', "%{$search}%")
                ->orWhere('year', 'LIKE', "%{$search}%");
            });
        }

        if ($request->input('status') == 0) {
            $query->where('status', 2);
        }

        if ($request->has('department') && !empty($request->input('department'))) {
            $query->where('department', $request->input('department'));
        }

        $files = $query->paginate(7)->appends($request->except('page'));

        // Get unique departments from files table
        $departments = File::select('department')
            ->distinct()
            ->whereNotNull('department')
            ->get();

        return view('archive.decline', compact('files', 'departments'));
    }


    public function pending(Request $request)
    {
        $query = File::query();

        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('book_number', 'LIKE', "%{$search}%")
                ->orWhere('year', 'LIKE', "%{$search}%")
                ->orWhere('members', 'LIKE', "%{$search}%");
            });
        }

        if ($request->input('status') == 0) {
            $query->where('status', 0);
        }

        if ($request->has('department') && !empty($request->input('department'))) {
            $query->where('department', $request->input('department'));
        }

          $files = $query
        ->orderByRaw('CAST(book_number AS UNSIGNED) ASC') // Sort by book number
        ->paginate(10)
        ->appends($request->except('page'));

        // Get unique departments from files table
        $departments = File::select('department')
            ->distinct()
            ->whereNotNull('department')
            ->get();

        return view('archive.pending', compact('files', 'departments'));
    }

     public function adminArchiveList(Request $request){

        $query = File::query();

        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                ->orwhere('book_number', 'LIKE', "%{$search}%")
                ->orWhere('year', 'LIKE', "%{$search}%")
                ->orWhere('adviser', 'LIKE', "%{$search}%");
            });
        }

        if ($request->input('status') == 0) {
            $query->where('status', 1);
        }

        if ($request->has('department') && !empty($request->input('department'))) {
            $query->where('department', $request->input('department'));
        }

        $files = $query
        ->orderByRaw('CAST(book_number AS UNSIGNED) ASC') // Sort by book number
        ->paginate(10)
        ->appends($request->except('page'));

        // Get unique departments from files table
        $departments = File::select('department')
            ->distinct()
            ->whereNotNull('department')
            ->get();

        return view('archive.list', compact('files', 'departments'));
    }


    public function adminPassword(Admin $admin){
        return view('admin.changepassword', ['admin' => $admin]);
    }

    public function adminUpload(){
       $lastFile = File::orderBy('book_number', 'desc')->first();

        if ($lastFile) {
            $bookNumber = str_pad((int)$lastFile->book_number + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $bookNumber = '0001';
        }

        return view('archive.upload', compact('bookNumber'));
        }

    public function adminprofileView(Admin $admin){
        return view('accounts.adminprofile', ['admin' => $admin]);
    }


    //for admin
    public function adminReset(){
        return view('accounts.resetadmin');
    }

   public function adminDashboard()
{

    $totalBorrowed = Borrow::count(); // adjust to your actual model/table for borrow records

    $recentUploads = File::latest()->take(8)->get();

    $totalUpload  = File::where('status', 1)->count();
    $totalPending = File::where('status', 0)->count();

    // Research by year
   $researchByYear = File::where('status', 1)
    ->selectRaw('`year`, COUNT(*) as total')
    ->groupBy('year')
    ->orderBy('year')
    ->pluck('total', 'year');

    // Department distribution — only BSAMT, BSEAT, and Others
    $deptCounts = File::selectRaw('department, COUNT(*) as total')
        ->groupBy('department')
        ->pluck('total', 'department');
    $deptTotal = $deptCounts->sum();
    $targetDepts = ['BSAMT', 'BSAET'];
    $deptDistribution = collect($targetDepts)
        ->mapWithKeys(function ($dept) use ($deptCounts, $deptTotal) {
            $count = $deptCounts->get($dept, 0);
            $pct = $deptTotal > 0 ? round(($count / $deptTotal) * 100, 1) : 0;
            return [$dept => $pct];
        });
    // Everything not in $targetDepts gets lumped into "Others"
    $othersCount = $deptCounts
        ->reject(fn($count, $dept) => in_array($dept, $targetDepts))
        ->sum();
    $deptDistribution['Others'] = $deptTotal > 0
        ? round(($othersCount / $deptTotal) * 100, 1)
        : 0;

    return view('admin.dashboard', compact(
        'totalUpload',
        'totalPending',
        'recentUploads',
        'researchByYear',
        'deptDistribution',
        'totalBorrowed'
    ));
}
    public function register(){
        return view('admin.register');
    }
    public function adminLogin(){
        return view('admin.login');
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

}
