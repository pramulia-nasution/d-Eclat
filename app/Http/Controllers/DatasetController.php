<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Dataset;
use App\Support;
use App\Imports\ImportDatasets;
use Maatwebsite\Excel\Facades\Excel;

class DatasetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()){
            $dataset = Dataset::all();
            return DataTables::of($dataset)
            ->addIndexColumn()
            ->addColumn('action',function($dataset){
                return '<a style="color:white;cursor:pointer" onclick="editForm('.$dataset->id.')" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>'.
                ' <a style="color:white;cursor:pointer" onclick="deleteData('.$dataset->id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })->make(true);
        }
        return view('data.dataset');
    }

    public function store(Request $request)
    {
        Dataset::updateOrCreate(['id'=>$request->id],[
            'usia'=>$request->usia,
            'gender'=>$request->gender,
            'code'=>$request->code,
            'pemakaian'=>$request->pemakaian,
            'tes'=>$request->tes,
            'pendidikan'=>$request->pendidikan,
            'pekerjaan'=>$request->pekerjaan
        ]);
        return response()->json(['success'=>'Data diperbaharui']);
    }

    public function edit(Dataset $dataset)
    {
        return response()->json($dataset);
    }

    public function updateSupp(Request $request){
        //Support::create(['supp'=>$request->supp]);
        Support::where('id',$request->id)->update(['supp'=>$request->supp]);
        return response()->json(['success'=>'Data diperbaharui']);
    }

    public function getSupport(){
        $support = Support::where('id',1)->first();
        return response()->json($support);
    }


    public function destroy($id)
    {
        Dataset::find($id)->delete();
        return response()->json(['success'=>'Data dihapus']);
    }

    public function truncate()
    {
        Dataset::truncate();
        return response()->json(['success'=>'Data dikosongkan']);
    }

    public function download()
    {
        $file = public_path().'/format.xlsx';

        $header = array(
            'Content-Type: application/xlsx',
        );
        return response()->download($file,'format.xlsx',$header);
    }

    public function import()
    {
        Excel::import(new ImportDatasets, request()->file('file'));
        return response()->json(['success'=>'Sukses Import Data']);
    }
}
