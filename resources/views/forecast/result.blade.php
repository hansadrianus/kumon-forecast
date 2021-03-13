@extends('layouts.materialpro')
@section('title') Hasil Peramalan @endsection
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
                <li class="breadcrumb-item"><a href="{{route('forecast.index')}}">Peramalan</a></li>
                <li class="breadcrumb-item active">Hasil</li>
            </ol>
        </div>
    </div>

    @include('partials.alert')
    <div class="row">
        <!-- column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Hasil Peramalan</h4>
                    <br>
                    
                    <div class="mb-2">
                        <h6 class="text-muted">Nama Siswa</h6>
                        <p class="text-black">{{$student->name}}</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted">Kelas</h6>
                        <p class="text-black">{{$student->grade}}</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted">Target Peramalan</h6>
                        <p class="text-black">{{$forecast_params['month']}} {{$forecast_params['year']}}</p>
                    </div>
                    <div class="row">
                            <div class="col-lg-6 col-12">
                                <h5>WMA</h5>
                                <div class="mb-3">
                                    <h6 class="text-muted">Parameter</h6>
                                    <div class="my-2 row">
                                        <div class="col-4">
                                            <span>WMA</span>
                                        </div>
                                        <div class="col-6">
                                            <span>{{$wma_params['n_wma']}}</span>
                                        </div>
                                    </div>
                                    <div class="my-2 row">
                                        <div class="col-4">
                                            <span>Bobot</span>
                                        </div>
                                        <div class="col-6">
                                            @foreach($wma_params['bobot'] as $bobot)
                                                <span>{{$bobot}}%</span><br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <h6 class="text-muted">Hasil</h6>
                                    <div class="my-2 row">
                                        <div class="col-4">
                                            <span>Peramalan</span>
                                        </div>
                                        <div class="col-6">
                                            <span>{{$wma['forecast']}}</span>
                                        </div>
                                    </div>                                
                                    <div class="my-2 row">
                                        <div class="col-4">
                                            <span>Mean Absolute Error</span>
                                        </div>
                                        <div class="col-6">
                                            <span>
                                                @if($wma['mean_absolute_error'])
                                                    {{$wma['mean_absolute_error']}}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <h5>ES</h5>
                                <div class="mb-4">
                                    <h6 class="text-muted">Parameter</h6>
                                    <div class="my-2 row">
                                        <div class="col-4">
                                            <span>Alpha</span>
                                        </div>
                                        <div class="col-6">
                                            <span>{{$ses_params['alpha']}}</span>
                                        </div>
                                    </div>                                
                                </div>
                                <div class="mb-2">
                                    <h6 class="text-muted">Hasil</h6>
                                    <div class="my-2 row">
                                        <div class="col-4">
                                            <span>Peramalan</span>
                                        </div>
                                        <div class="col-6">
                                            <span>{{$ses['forecast']}}</span>
                                        </div>
                                    </div>                                
                                    <div class="my-2 row">
                                        <div class="col-4">
                                            <span>Mean Absolute Error</span>
                                        </div>
                                        <div class="col-6">
                                            <span>
                                                @if($ses['mean_absolute_error'])
                                                    {{$ses['mean_absolute_error']}}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('script')
    <!-- <script src="{{asset('js/datatables.min.js')}}"></script> -->
    <script>
        $(document).ready(function()) {
            $('#forecast').addClass('active');
        }

        var wma = $('#wma-option').val()
        generateFormBobot(wma)

        $('#wma-option').on('change', function() {
            wma = $(this).val()
            generateFormBobot(wma)
        })        

        function generateFormBobot(wma) {
            $('.bobot-wma').empty();

            for (let i = 0; i < wma; i++) {                
                $('.bobot-wma').append(
                    '<div class="col-lg-4 my-2">'+
                        `<label for="">Bobot ${i+1} (%)</label>` +
                        '<input type="number" class="form-control" name="bobot[]">' +
                    '</div>'
                )
            }            
        }
    </script>
@endsection