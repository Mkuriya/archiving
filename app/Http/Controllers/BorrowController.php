<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
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
