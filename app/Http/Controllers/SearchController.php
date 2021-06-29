<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if (! $request->filled('searchVal')) {
            return back();
        }

        $keyword = $request->input('searchVal');
        return redirect()->route('dashboard.timeline', [$keyword]);
        // $agenda = Agenda::whereKode($keyword)->first();
        // if(!$agenda){
        //     abort(404);
        // }
        // return view('dashboard.timeline', compact('agenda'));
    }
}
