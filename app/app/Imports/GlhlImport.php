<?php

namespace App\Imports;

use App\GLHL;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class GlhlImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new GLHL([
            'id'     => strtoupper(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10)),
            'name'     => $row['name'],
            'code1'    => $row['code1'], 
            'code2'    => $row['code2'],
            'dvt'      => $row['dvt'],
        ]);
    }
}
