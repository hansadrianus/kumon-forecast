<?php

namespace App\Imports;

use App\StudentScore;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentScoreImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        //Index in array = column in excel - must be in string
        return new StudentScore([
            'student_id' => $row['nim'],
            'month' => $row['month'],
            'year' => $row['year'],
            'score' => $row['score'],
        ]);
    }
}
