@extends('layouts.materialpro')
@section('title') Tambah Siswa @endsection
@section('style')
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Siswa</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{route('student.index')}}">Siswa</a></li>
                <li class="breadcrumb-item active">Tambah Siswa</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    @include('partials.alert')
    <div class="row">
        <!-- column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Input Data Siswa</h4>
                    <br>
                    <form action="{{route('student.store')}}" method="post">
                        @csrf
                        <div class="row form-siswa mb-2">
                            <div class="form-group col-md-4 col-12">
                                <label for="student-id">ID Siswa</label>
                                <input required type="number" name="student_id[]" class="form-control" id="student-id" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="student-name">Nama Siswa</label>
                                <input required type="text" name="student_name[]" class="form-control" id="student-name">
                            </div>
                            <div class="form-group col-md-2 col-12">
                                <div>
                                    <label for="student-class">Kelas</label>
                                </div>
                                <select name="student_grade[]" style="width: 100%;" class="custom-select" id="student-class">
                                    <option value="PG A">PG A</option>
                                    <option value="PG B">PG B</option>
                                    <option value="TK A">TK A</option>
                                    <option value="TK B">TK B</option>
                                    <option value="SD 1">SD 1</option>
                                    <option value="SD 2">SD 2</option>
                                    <option value="SD 3">SD 3</option>
                                    <option value="SD 4">SD 4</option>
                                    <option value="SD 5">SD 5</option>
                                    <option value="SD 6">SD 6</option>
                                    <option value="SMP 7">SMP 7</option>
                                    <option value="SMP 8">SMP 8</option>
                                    <option value="SMP 9">SMP 9</option>
                                    <option value="SMA 10">SMA 10</option>
                                    <option value="SMA 11">SMA 11</option>
                                    <option value="SMA 12">SMA 12</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center my-2">
                            <button type="button" class="btn btn-info" id="btn-append-form">Tambah Form</button>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
@endsection
@section('script')    
    <script>
        $('#student').addClass('active')

        $('#btn-append-form').on('click', function() {            
            $('.form-siswa:first').clone().insertBefore($(this).parent())
            // $($(this)).before($('.form-siswa:first')).clone(true)
            // console.log($(this).parent());
        })
    </script>
@endsection