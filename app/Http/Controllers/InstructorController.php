<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Instructorbook;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    //


   public function instructorAssign(Request $request)
{
    $validated = $request->validate([
        'instructor_id' => 'required|exists:instructors,id',
        'file_id' => 'required|exists:files,id',
    ]);

    $exists = Instructorbook::where('instructor_id', $validated['instructor_id'])
                ->where('file_id', $validated['file_id'])
                ->exists();

    if ($exists) {
        return redirect('/admin/dashboard/instructor')
            ->with('error', 'This instructor is already assigned to this book.');
    }

    Instructorbook::create([
        'instructor_id' => $validated['instructor_id'],
        'file_id' => $validated['file_id'],
    ]);

    return redirect('/admin/dashboard/instructor')
        ->with('success', 'Instructor assigned successfully.');
}
   public function instructorRegister(Request $request)
{
    if (Instructor::where('name', $request->name)->exists()) {
        return back()->with('error', 'Instructor already exists.');
    }

    Instructor::create([
        'name' => $request->name,
    ]);

    return back()->with('success', 'Instructor registered successfully.');
}

}
