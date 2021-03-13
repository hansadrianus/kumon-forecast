@extends('layouts.materialpro')
@section('title') Siswa @endsection
@section('style')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
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
                <li class="breadcrumb-item active">Siswa</li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <a href="{{route('student.create')}}" class="btn waves-effect waves-light btn-danger pull-right"> Tambah Siswa</a>
            <a class="btn waves-effect waves-light btn-info pull-right text-white" data-toggle="modal" data-target="#uploadScore"> Upload Student Score</a>
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
                    <h4 class="card-title">Daftar Siswa</h4>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th style="width:30%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $s)
                                <tr>
                                    <td>{{$s->id}}</td>
                                    <td>{{$s->name}}</td>
                                    <td>{{$s->grade}}</td>
                                    <td>
                                        <a href="{{route('student.view', $s->id)}}" class="btn btn-primary"><i class="mdi mdi-eye-outline"></i> Lihat</a>
                                        <a href="{{route('student.edit', $s->id)}}" class="btn btn-info"><i class="mdi mdi-lead-pencil"></i> Edit</a>
                                        <a href="{{route('student.delete', $s->id)}}" class="btn btn-danger"><i class="mdi mdi-delete-empty"></i> Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

    <!-- The Modal -->
    <div class="modal" id="uploadScore">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('student.score.import') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Upload Student Score</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
            
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="file" name="upload_student_score" />
                    </div>
            
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Upload</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Download Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        }) 
    </script>
@endsection