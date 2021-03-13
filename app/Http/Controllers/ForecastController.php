<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class ForecastController extends Controller
{
    public function index()
    {
        $student = Student::orderBy('name','asc')->get();
        return view('forecast.index')->with([
            'students' => $student
        ]);
    }

    public function result(Request $request)
    {
        // dd($request->all());

        if (array_sum($request->bobot) != 100) {
            return redirect()->back()->withDanger('Total bobot harus 100%.');
        }

        $student = Student::find($request->student);
        $scores = $student->score->toArray();

        foreach ($scores as &$s) {
            $s['date'] = date_create($s['year'].'-'.$s['month']);
        }

        usort($scores, function($a, $b)
        {
            return $a['date'] <=> $b['date'];
        });

        if ($request->ses_month_start != null) {
            $ses = $this->ses(
                $scores,                                                                // student score
                date_create($request->year.'-'.$request->month),                        // date target
                date_create($request->ses_year_start.'-'.$request->ses_month_start),    // date start
                date_create($request->ses_year_end.'-'.$request->ses_month_end),        // date end
                $request->alpha,                                                         // alpha
                count($scores)
            );
        } else {
            $ses = $this->ses(
                $scores,                                           // student score
                date_create($request->year.'-'.$request->month),   // date target
                null,
                null,
                $request->alpha,                                    // alpha
                count($scores)
            );
        }

        if(is_a($ses, 'Illuminate\Http\RedirectResponse')) {
            return $ses;
        }

        $ses_params['alpha'] = $request->alpha;

        $bobot = array_map(function($n){
            return $n/100;
        }, $request->bobot);

        $dateEnd = date_create($request->year.'-'.$request->month);
        // dd(date_create($request->year."-".$request->month));
        $indexEnd = array_search($dateEnd, array_column($scores, 'date'));
        // dd($scores);
        // dd($indexEnd);

        $dateStart = date_sub($dateEnd,date_interval_create_from_date_string($request->wma." months"));
        $indexStart = array_search($dateStart, array_column($scores, 'date'));

        // dd($indexEnd);

        if (!$indexEnd) {
            $scoreSlice = array_slice($scores, $indexStart);
            $scoreForecast = null;
        } else {
            $scoreSlice = array_slice($scores, $indexStart, $indexEnd-$indexStart);
            $scoreForecast = $scores[$indexEnd];
        }

        // dd(array_slice($scores, $indexStart, $indexEnd-$indexStart));

        if (count($scoreSlice) != $request->wma) {
            return redirect()->back()->withDanger('Data tidak mencukupi untuk '.$request->wma.'WMA. Mohon pilih WMA yang lain.');
        }

        $wma = $this->wma($scoreSlice, $bobot, $scoreForecast, count($scores), $request->wma);
        $wma_params['n_wma'] = $request->wma;
        $wma_params['bobot'] = $request->bobot;

        $forecast_params['year'] = $request->year;
        switch ($request->month) {
            case '1':
                $forecast_params['month'] = 'Januari';
                break;
            case '2':
                $forecast_params['month'] = 'Februari';
                break;
            case '3':
                $forecast_params['month'] = 'Maret';
                break;
            case '4':
                $forecast_params['month'] = 'April';
                break;
            case '5':
                $forecast_params['month'] = 'Mei';
                break;
            case '6':
                $forecast_params['month'] = 'Juni';
                break;
            case '7':
                $forecast_params['month'] = 'Juli';
                break;
            case '8':
                $forecast_params['month'] = 'Agustus';
                break;
            case '9':
                $forecast_params['month'] = 'September';
                break;
            case '10':
                $forecast_params['month'] = 'Oktober';
                break;
            case '11':
                $forecast_params['month'] = 'November';
                break;
            case '12':
                $forecast_params['month'] = 'Desember';
                break;

        }

        return view('forecast.result')->with([
            'student' => $student,
            'wma' => $wma,
            'wma_params' => $wma_params,
            'ses' => $ses,
            'ses_params' => $ses_params,
            'forecast_params' => $forecast_params
        ]);
    }

    function wma($score, $weight, $scoreForecast=null, $totalData, $wma)
    {
        $forecast = 0;
        $result = [];
        for ($i=0; $i < count($score); $i++) {
            $forecast += $score[$i]['score'] * $weight[$i];
        }

        if ($scoreForecast!=null) {
            $result['forecast'] = $forecast;
            $result['forecast_error'] = $scoreForecast['score']-$forecast;
            $result['absolute_error'] = abs($result['forecast_error']);
            $result['squared_error'] = pow($result['absolute_error'], 2);
            $result['percentage_error'] = round($result['forecast_error']/$scoreForecast['score']*100)."%";
            $result['absolute_percentage_error'] = abs($result['percentage_error'])."%";
            $result['mean_absolute_error'] = $result['absolute_error'] / ($totalData-$wma);
        } else {
            $result['forecast'] = $forecast;
            $result['mean_absolute_error'] = null;
        }
        return $result;
    }

    function ses($studentScore, $dateTarget, $dateStart = null, $dateEnd = null, $alpha, $totalData)
    {
        $indexTarget = array_search($dateTarget, array_column($studentScore, 'date'));

        if (!$indexTarget) {

            if (date_diff($dateTarget, end($studentScore)['date'])->format('%m') > 1) {
                return redirect()->back()->withDanger('Data tidak mencukupi untuk peramalan bulan '.$dateTarget->format('m').' tahun '.$dateTarget->format('Y').'.');
            }
            $ses = $this->ses_forecast($studentScore, null, $alpha, $totalData);
        } else {
            if ($dateStart != null && $dateEnd != null) {
                $indexStart = array_search($dateStart, array_column($studentScore, 'date'));
                $indexEnd = array_search($dateEnd, array_column($studentScore, 'date'));

                if ($dateTarget == $dateEnd) {
                    return redirect()->back()->withDanger('Data bulan selesai tidak boleh sama dengan data bulan yang diramalkan.');;
                }
                if (!$indexStart && $indexStart != 0) {
                    return redirect()->back()->withDanger('Tidak ada data pada bulan '.$dateStart->format('m').' tahun '.$dateStart->format('Y').'.');
                }
                if (!$indexEnd) {
                    return redirect()->back()->withDanger('Tidak ada data pada bulan '.$dateEnd->format('m').' tahun '.$dateEnd->format('Y').'.');
                }

                $scoreSlice = array_slice($studentScore, $indexStart, $indexTarget);

            } else {
                $scoreSlice = array_slice($studentScore, 0, $indexTarget);
            }

            $scoreTarget = $studentScore[$indexTarget];

            $ses = $this->ses_forecast($scoreSlice, $scoreTarget, $alpha, $totalData, $indexTarget);
        }

        return $ses;
        // return redirect()->back()->withDanger('Error');
    }

    function ses_forecast($scoreSlice, $scoreTarget, $alpha, $totalData, $usedData)
    {
        $forecast = $scoreSlice[0]['score'];

        if (count($scoreSlice) > 1) {
            for ($i=1; $i < count($scoreSlice); $i++) {
                $score = $scoreSlice[$i]['score'];
                $forecast = round(($score*$alpha) + ((1-$alpha)*$forecast));
            }

            if ($scoreTarget!=null) {
                $ses['forecast'] = $forecast;
                $ses['forecast_error'] = $scoreTarget['score'] - $forecast;
                $ses['absolute_error'] = abs($ses['forecast_error']);
                $ses['squared_error'] = pow($ses['absolute_error'], 2);
                $ses['percentage_error'] = round($ses['forecast_error']/$scoreTarget['score']*100)."%";
                $ses['absolute_percentage_error'] = abs($ses['percentage_error'])."%";
                $ses['mean_absolute_error'] = $ses['absolute_error'] / 11;
            } else {
                $ses['forecast'] = $forecast;
                $ses['mean_absolute_error'] = null;
            }
        } else {
            if ($scoreTarget != null) {
                $ses['forecast'] = $forecast;
                $ses['forecast_error'] = $scoreTarget['score'] - $forecast;
                $ses['absolute_error'] = abs($ses['forecast_error']);
                $ses['squared_error'] = pow($ses['absolute_error'], 2);
                $ses['percentage_error'] = round($ses['forecast_error']/$scoreTarget['score']*100)."%";
                $ses['absolute_percentage_error'] = abs($ses['percentage_error'])."%";
                $ses['mean_absolute_error'] = $ses['absolute_error'] / ($totalData-$usedData);
            } else {
                $ses['forecast'] = $forecast;
                $ses['mean_absolute_error'] = null;
            }
        }

        // dd($ses);

        return $ses;
    }
}
