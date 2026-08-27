<?php

namespace App\Http\Controllers;

use App\Models\logbook;
use Illuminate\Http\Request;

class LogBookController extends Controller
{
     public function createlogbook(Request $request){
        $validated = $request->validate([
            "date" => 'required',
            "b_no" => 'required',
            "b_name" => 'required',
            "s_name" => 'required',
        ]);
        $logbook = logbook::create($validated);
    return back()->with('success', 'Borrow Book successfully.');
    }
}
