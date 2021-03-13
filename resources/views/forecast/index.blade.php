@extends('layouts.materialpro')
@section('title') Peramalan @endsection
@section('style')
    <!-- <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}"> -->
@endsection
@section('body')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Peramalan</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
                <li class="breadcrumb-item active">Peramalan</li>
            </ol>
        </div>
    </div>

    @include('partials.alert')
    <div class="row">
        <!-- column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <!-- <h4 class="card-title">Daftar Siswa</h4> -->
                    <!-- <br> -->
                    <form action="{{route('forecast.result')}}" method="post">
                        @csrf
                        <div class="mb-2">                            
                            <div class="form-group">
                                <div>
                                    <label for="student-class">Pilih Siswa</label>
                                </div>
                                <select name="student" style="width: 100%;" class="custom-select">
                                    @foreach($students as $s)
                                        <option value="{{$s->id}}">{{$s->name}} - {{$s->id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="">Bulan</label>
                                    <br>
                                    <select name="month" class="custom-select" style="width:100%;">                                    
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
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="">Tahun</label>
                                    <input type="number" required name="year" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <h5>WMA</h5>
                                <div class="mb-2">
                                    <select name="wma" class="custom-select" id="wma-option" style="width:100%">
                                        <option value="2">2 WMA</option>
                                        <option value="3">3 WMA</option>
                                        <option value="4">4 WMA</option>
                                        <option value="5">5 WMA</option>
                                        <option value="6">6 WMA</option>
                                    </select>
                                </div>
                                <div class="bobot-wma row">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <h5>SES</h5>
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="">Nilai α</label>
                                        <input type="number" name="alpha" min="0.1" max="0.9" step="0.1" required class="form-control">
                                    </div>
                                </div>

                                <h5>Data Bulan Mulai</h5>
                                <div class="row my-2">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label for="">Bulan</label>
                                            <br>
                                            <select name="ses_month_start" id="ses-month-start" class="custom-select" style="width:100%;">                                    
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
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label for="">Tahun</label>
                                            <input type="number" required name="ses_year_start" id="ses-year-start" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <h5>Data Bulan Selesai</h5>
                                <div class="row my-2">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label for="">Bulan</label>
                                            <br>
                                            <select name="ses_month_end" id="ses-month-end" class="custom-select" style="width:100%;">                                    
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
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label for="">Tahun</label>
                                            <input type="number" required name="ses_year_end" id="ses-year-end" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-1">
                                    <div class="custom-control px-0 custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="cb-useall">
                                        <label class="custom-control-label" for="cb-useall">Gunakan seluruh data</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-5"></div>
                            <button type="submit" class="col-lg-2 col-sm-12 my-2 btn btn-primary">Submit</button>
                            <div class="col-lg-5"></div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('script')
    <!-- <script src="{{asset('js/datatables.min.js')}}"></script> -->
    <script>
        $(document).ready(function() {
            var checked = $('#cb-useall').prop('checked');
            console.log(checked);
            if (checked) {
                disableSESMonth()
            } else {
                enableSESMonth()
            }
        })
        var wma = $('#wma-option').val()        
        generateFormBobot(wma)

        $('#wma-option').on('change', function() {
            wma = $(this).val()
            generateFormBobot(wma)
        })
        
        $('#cb-useall').prop("checked",true).trigger("change");
        $('#cb-useall').on('change', function() {
            checked = $(this).prop('checked')
            console.log(checked);
            if (checked) {
                disableSESMonth()
            } else {
                enableSESMonth()
            }
        })

        function disableSESMonth() {
            $('#ses-month-start').attr('disabled', true)
            $('#ses-year-start').attr('disabled', true)
            $('#ses-month-end').attr('disabled', true)
            $('#ses-year-end').attr('disabled', true)
        }

        function enableSESMonth() {
            $('#ses-month-start').attr('disabled', false)
            $('#ses-year-start').attr('disabled', false)
            $('#ses-month-end').attr('disabled', false)
            $('#ses-year-end').attr('disabled', false)
        }

        function generateFormBobot(wma) {
            $('.bobot-wma').empty();

            for (let i = 0; i < wma; i++) {                
                $('.bobot-wma').append(
                    '<div class="col-lg-4 my-2">'+
                        `<label for="">Bobot ${i+1} (%)</label>` +
                        '<input type="number" required class="form-control" name="bobot[]">' +
                    '</div>'
                )
            }            
        }
    </script>
@endsection