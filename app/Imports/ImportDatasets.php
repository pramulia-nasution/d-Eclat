<?php

namespace App\Imports;

use App\Dataset;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportDatasets implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Dataset([
            'code' =>$row[0],
            'gender'=>$row[1],
            'usia'=>$row[2],
            'pendidikan'=>$row[3],
            'pekerjaan'=>$row[4],
            'tes'=>$row[5],
            'pemakaian'=>$row[6],
        ]);
    }
}
