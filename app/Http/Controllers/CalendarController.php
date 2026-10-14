<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{


    public function delete(Request $request)
{
    Calendar::where('note_date', $request->date)->delete();

    return response()->json([
        'success' => true
    ]);
}


    public function save(Request $request)
{
    Calendar::updateOrCreate(
        [
            'note_date' => $request->date
        ],
        [
            'note' => $request->note
        ]
    );

    return response()->json([
        'success' => true
    ]);
}


    public function load(Request $request)
    {
        $year = $request->year;
        $month = $request->month;

        $notes = Calendar::whereYear('note_date', $year)
            ->whereMonth('note_date', $month)
            ->get();

        $data = [];

        foreach ($notes as $note) {
            $data[$note->note_date] = $note->note;
        }

        return response()->json($data);
    }


}
