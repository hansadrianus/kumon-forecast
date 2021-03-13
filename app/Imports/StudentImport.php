<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new Student([
            'id' => $row['nim'],
            'name' => $row['nama_siswa'],
            'grade' => $row['kelas'],
        ]);
    }
}
