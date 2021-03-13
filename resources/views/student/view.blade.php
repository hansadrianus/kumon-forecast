@extends('layouts.materialpro')
@section('title') Detail Siswa @endsection
@section('style')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Detail Siswa</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{route('student.index')}}">Siswa</a></li>
                <li class="breadcrumb-item active">{{$student->id}}</li>
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
                    <h4 class="card-title">{{$student->name}}</h4>
                    <br>
                    <div class="mb-4">
                        <h6 class="text-muted">ID Siswa</h6>
                        <p class="text-black">{{$student->id}}</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted">Nama Siswa</h6>
                        <p class="text-black">{{$student->name}}</p>
                    </div>
                    <div class="">
                        <h6 class="text-muted">Kelas</h6>
                        <p class="text-black">{{$student->grade}}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <div class="row mb-4">
                        <div class="col-md-5 col-8 align-self-center">
                            <h4 class="card-title">Capaian Materi Siswa</h4>
                        </div>
                        <div class="col-md-7 col-4 align-self-center">
                            <button type="button" data-toggle="modal" data-target="#scoreModal" class="btn waves-effect waves-light btn-info pull-right"> Input Capaian</button>
                        </div>
                    </div>
                    <div class="mt-1">
                        <table class="table table-striped"  id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($student->score as $score)                                
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>
                                    @switch($score->month)
                                        @case(1)
                                            Januari
                                            @break
                                        @case(2)
                                            Februari
                                            @break
                                        @case(3)
                                            Maret
                                            @break
                                        @case(4)
                                            April
                                            @break
                                        @case(5)
                                            Mei
                                            @break
                                        @case(6)
                                            Juni
                                            @break
                                        @case(7)
                                            Juli
                                            @break
                                        @case(8)
                                            Agustus
                                            @break
                                        @case(9)
                                            September
                                            @break
                                        @case(10)
                                            Oktober
                                            @break
                                        @case(11)
                                            November
                                            @break
                                        @case(12)
                                            Desember
                                            @break
                                    @endswitch
                                    </td>
                                    <td>{{$score->year}}</td>
                                    <td>{{$score->score}}</td>
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
    <div class="modal fade" id="scoreModal" tabindex="-1" role="dialog" aria-labelledby="scoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title card-title">Input Capaian Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('student.score.store')}}" method="post">
                    @csrf
                    <div class="row form-capaian mb-2">
                        <input type="hidden" name="student_id" value="{{$student->id}}">
                        <div class="col-md-4 col-12 form-group">
                            <label for="select-month">Bulan</label>
                            <br>
                            <select style="width:100%;" class="custom-select" name="month[]" id="select-month">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 form-group">
                            <label for="year">Tahun</label>
                            <input required type="number" class="form-control" name="year[]" id="year">
                        </div>
                        <div class="col-md-4 col-12 form-group">
                            <label for="score">Capaian</label>
                            <input required type="number" class="form-control" name="score[]" id="score">
                        </div>
                    </div>
                </form>
                <div class="d-flex justify-content-center mt-3">
                    <button type="button" class="btn btn-info" id="btn-append-form">Tambah Form</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="btn-submit">Simpan</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script>
    
        $(document).ready(function() {
            $('#dataTable').DataTable();
            $('#student').addClass('active')
        }) 

        $('#btn-submit').on('click', function() {
            $('form').submit();
        });

        $('#btn-append-form').on('click', function() {            
            $('.form-capaian:first').clone().appendTo('form')
        })
    </script>
@endsection