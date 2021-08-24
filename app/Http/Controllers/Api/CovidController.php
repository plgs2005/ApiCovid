<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Covid;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class CovidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Covid $covid)
    {
        $covid = $covid->all();
        return response()->json($covid);
    }

    public function show(Covid $covid, Request $request)
    {
        $state = $request->state;
        $startDate = date($request->startDate);
        $endDate = date($request->endDate);


        $covid = Covid::select('*')->where('state', "{$request->state}")->whereBetween('date', [$startDate, $endDate])->get();

        return response()->json($covid);
    }

    protected function consultaCliente(Request $request)
    {

        $tokem = 'Token cd06accc7cba9e0b48b4d3106f3ea4359f593725';
        $url = 'https://api.brasil.io/v1/dataset/covid19/caso/data/?state=PR&date=2020-05-10';



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER=> false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: '. $tokem
            ),
        ));

        $response = json_encode(curl_exec($curl));

        curl_close($curl);
        dd($response);
    }
}