<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\ConclusionExport;
use PDF;

class ExportController extends Controller
{
    public function exportExcel(){
        $nama = 'hasilDeclat_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new ConclusionExport,$nama);
    }

    public function exportPdf() {
        $declat= DB::table('declats')->where('iterasi','5')->get();
        $confidences = DB::table('confidences')->get();
        $evaluation = DB::table('evaluation')->get();
        $pdf = PDF::loadView('layouts.export',compact('declat','confidences','evaluation'));
        $nama = 'hasilDeclat_'.date('Y-m-d_H-i-s').'.pdf';
        return $pdf->download($nama);
    }
}
