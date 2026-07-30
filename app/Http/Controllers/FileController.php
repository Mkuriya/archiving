<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Borrow;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function createBorrow(Request $request){
        $validated = $request->validate([
            "b_date" => 'required',
            "b_no" => 'required',
            "b_name" => 'required',
            "s_name" => 'required',
            "r_date" => 'nullable',
            'status' => 'required',
        ]);
        $borrows = Borrow::create($validated);
    return back()->with('success', 'Borrow Book successfully.');
    }

    public function updateAbstract(Request $request, $id)/* Function for details update */
    {
        $request->validate([
            'title' => 'nullable|string',
            'abstract' => 'nullable|string',
            'year' => 'required|integer',
            'members' => 'required|string',
            'adviser' => 'nullable|string',
            'department' => 'required|string',
            'citation' => 'required|string',
        ]);

        $file = File::findOrFail($id);

        $file->update([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'year' => $request->year,
            'members' => $request->members,
            'adviser' => $request->adviser,
            'department' => $request->department,
            'citation' => $request->citation,
        ]);

        return back()->with('success', 'Details updated successfully.');
    }

    public function destroy($id)
    {
        $item = File::findOrFail($id);

        $item->delete();

        return back()->with('success', 'File deleted successfully.');
    }
    public function declinefileUpdate(File $file, Request $request) /* Function for pending update */
    {
        $data = $request->validate([
            'status' => 'required',
        ]);

        $data['status'] = strip_tags($data['status']);

        $file->update($data);

        return redirect('/admin/dashboard/archive/decline')->with('success', 'File updated successfully!');
    }

        public function fileUpdate(File $file, Request $request) /* Function for pending update */
    {
        $data = $request->validate([
            'status' => 'required',
            'adviser' => 'nullable|string',
            'abstract' => 'nullable|string',
            'title' => 'nullable|string',
            'department' => 'nullable|string',
            'book_number' => 'required',
            'members' => 'required',
            'citation' => 'required',
            'year' => 'required',
        ]);

        $data['title'] = strip_tags($data['title']);
        $data['status'] = strip_tags($data['status']);
        $data['adviser'] = strip_tags($data['adviser']);
        $data['abstract'] = strip_tags($data['abstract']);
        $data['department'] = strip_tags($data['department']);
        $data['book_number'] = strip_tags($data['book_number']);
        $data['members'] = strip_tags($data['members']);
        $data['citation'] = strip_tags($data['citation']);
        $data['year'] = strip_tags($data['year']);

        $file->update($data);

        return redirect('/admin/dashboard/archive/pending')->with('success', 'File updated successfully!');
    }

    public function fileUpload(Request $request){
        $validated = $request->validate([
            "title" => 'required',
            "year" => 'required|max:4',
            "members" => 'required',
            "adviser" => 'nullable|string',
            "abstract" => 'nullable|string',
            "department" => 'required',
            'citation' => 'required',
            'book_number' => 'required|unique:files,book_number',
            'status' => 'required',
        ]);
        $upload = File::create($validated);
        return redirect('/admin/dashboard')->with('success', 'File uploaded successfully!');
    }
}
