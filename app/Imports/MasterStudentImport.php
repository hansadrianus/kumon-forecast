<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterStudentImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Student' => new StudentImport(),
            'Score' => new StudentScoreImport()
        ];
    }
}
