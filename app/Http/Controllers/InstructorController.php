<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Instructor;

class InstructorController extends Controller
{
    //


public function instructorRegister(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:instructors,name',
    ]);

    Instructor::create([
        'name' => $validated['name'],
    ]);

    return redirect('/admin/dashboard/instructor')
            ->with('success', 'Instructor registered successfully.');
}

}
