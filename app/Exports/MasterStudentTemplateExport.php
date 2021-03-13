<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterStudentTemplateExport implements WithMultipleSheets, WithHeadings
{
    use Exportable;

    public function sheets() : array
    {
        $sheets = [];
        $sheets[0] = "Student";
        $sheets[1] = "Score";
        return $sheets;
    }

    public function title() : string
    {
        return "Student";
    }

    public function headings() : array
    {
        return [
            'NIM',
            'Nama Siswa',
            'Kelas',
        ];
    }
}
