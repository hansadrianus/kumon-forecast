<?php

namespace App\Http\Controllers;

use App\Exports\MasterStudentTemplateExport;
use App\Imports\MasterStudentImport;
use Illuminate\Http\Request;
use App\Student;
use App\StudentScore;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return view('student.index')->with('students', $students);
    }

    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'student_id.*' => 'required',
            'student_name.*' => 'required',
            'student_grade.*' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withDanger($validate->errors()->first());
        }

        $bulkStudent = [];
        for ($i=0; $i < count($request->student_id); $i++) {
            array_push($bulkStudent, [
                'id' => $request->student_id[$i],
                'name' => $request->student_name[$i],
                'grade' => $request->student_grade[$i]
            ]);
        }

        $student = Student::insert($bulkStudent);

        if ($student) {
            return redirect()->route('student.index')->withSuccess('Berhasil menambahkan siswa baru.');
        } else {
            return redirect()->back()->withDanger('Gagal menambahkan siswa.');
        }
    }

    public function view($id)
    {
        $student = Student::find($id)->load('score');
        return view('student.view')->with('student', $student);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect()->back()->withDanger('Data tidak ditemukan!');
        }

        $student->delete();
        return redirect()->back()->withSuccess('Data berhasil dihapus.');
    }

    public function storeScore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month.*' => 'required',
            'year.*' => 'required',
            'score.*' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withDanger($validator->errors()->first());
        }

        $bulkScore = [];
        for ($i=0; $i < count($request->month); $i++) {
            array_push($bulkScore, [
                'month' => $request->month[$i],
                'year' => $request->year[$i],
                'score' => $request->score[$i],
                'student_id' => $request->student_id
            ]);
        }

        $score = StudentScore::insert($bulkScore);

        if ($score) {
            return redirect()->back()->withSuccess('Berhasil menambahkan capaian siswa.');
        } else {
            return redirect()->back()->withDanger('Gagal menambahkan data.');
        }
    }

    public function studentScoreImport(){
        Excel::import(new MasterStudentImport, request()->file('upload_student_score'));
        return redirect()->route('student.index')->withSuccess('Test Upload Passed');
    }

    public function importTemplate(){
        return (new MasterStudentTemplateExport)->download('student_import_template.xlsx');
    }
}
