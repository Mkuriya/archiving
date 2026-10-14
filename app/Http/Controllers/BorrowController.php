<?php

namespace App\Http\Controllers;

use App\Models\BookScan;
use App\Models\Borrow;
use App\Models\File;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
        public function scan()
    {
        $files = File::with('scan')->where('status', 1)->paginate(10);
        return view('books.scan', compact('files'));
    }

    public function toggleScan($id)
    {
        $scan = BookScan::firstOrCreate(['file_id' => $id]);
        $scan->is_scanned = !$scan->is_scanned;
        $scan->scanned_at = $scan->is_scanned ? now() : null;
        $scan->save();

        return back()->with('success', 'Scan status updated.');
    }

    public function toggleEdit($id)
    {
        $scan = BookScan::firstOrCreate(['file_id' => $id]);
        $scan->is_edited = !$scan->is_edited;
        $scan->edited_at = $scan->is_edited ? now() : null;
        $scan->save();

        return back()->with('success', 'Edit status updated.');
    }
     public function destroy($id)
    {
        $item = Borrow::findOrFail($id);

        $item->delete();

        return back()->with('success', 'Item deleted successfully.');
    }


    public function borrowUpdate(Request $request, $file)
    {
        $borrow = Borrow::findOrFail($file);

        $request->validate([
            'b_name' => 'required|string|max:255',
            's_name' => 'required|string|max:255',
            'b_date' => 'required',
            'r_date' => 'nullable',
            'status' => 'required|integer',
        ]);

        $borrow->update([
            'b_name' => $request->b_name,
            's_name' => $request->s_name,
            'b_date' => $request->b_date,
            'r_date' => $request->r_date,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Borrow record updated successfully.');
    }

}
