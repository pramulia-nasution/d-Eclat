<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ConclusionExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View {
        return view('layouts.export',[
            'declat'=> DB::table('declats')->where('iterasi','5')->get(),
            'confidences'=>DB::table('confidences')->get(),
            'evaluation'=>DB::table('evaluation')->get()
        ]);
    }
}
