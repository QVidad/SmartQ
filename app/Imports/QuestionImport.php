<?php

namespace App\Imports;

use App\Qs;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class QuestionImport implements ToModel
{
    public function startRow(): int
    {
        return 3; // Start reading from the third row (index 3)
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ((int) $row[8] === 0) {
            return null; // Skip this row
        }

        $row[8] = (int) $row[8];
        $row[9] = (int) $row[9];
        return new Qs([
            //
            'qdesc'     => $row[0],
            'opt1'    => $row[1], 
            'opt2'    => $row[2], 
            'opt3'    => $row[3], 
            'opt4'    => $row[4], 
            'opt5'    => $row[5], 
            'ans'    => $row[6], 
            'reff'    => $row[7], 
            'topic_id'    => $row[8], 
            'created_by'    => $row[9], 
        ]);
    }
}
