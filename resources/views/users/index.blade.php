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
            <h3 class="text-themecolor m-b-0 m-t-0">Daftar Staff</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
                <li class="breadcrumb-item active">Staff</li>
            </ol>
        </div>
        {{-- <div class="col-md-7 col-4 align-self-center">
            <a href="{{route('student.create')}}" class="btn waves-effect waves-light btn-danger pull-right"> Tambah Siswa</a>
        </div> --}}
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
                    <h4 class="card-title">Daftar Staff</h4>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Staff</th>
                                    <th>Email</th>
                                    <th>Terdaftar Pada</th>
                                    {{-- <th style="width:30%;">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staff as $s)
                                <tr>
                                    <td>{{$s->id}}</td>
                                    <td>{{$s->name}}</td>
                                    <td>{{$s->email}}</td>
                                    <td>{{\Carbon\Carbon::parse($s->created_at)->toFormattedDateString()}}</td>
                                    {{-- <td>
                                        <a href="{{route('student.view', $s->id)}}" class="btn btn-primary"><i class="mdi mdi-eye-outline"></i> Lihat</a>
                                        <a href="{{route('student.edit', $s->id)}}" class="btn btn-info"><i class="mdi mdi-lead-pencil"></i> Edit</a>
                                        <a href="{{route('student.delete', $s->id)}}" class="btn btn-danger"><i class="mdi mdi-delete-empty"></i> Hapus</a>
                                    </td> --}}
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
@endsection
@section('script')
<script src="{{asset('js/datatables.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    }) 
</script>
@endsection