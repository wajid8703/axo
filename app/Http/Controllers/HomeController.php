<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * Search movie by title as Batman by default
     */
    public function index(Request $request)
    {   
        
        $url = "https://api.met.no/weatherapi/locationforecast/2.0/compact?lat=60.10&lon=9.58";
        $data = $this->sendCurlRequest($url); //send curl request

        $weather_data = array();
        if(isset($data->properties->timeseries)){
            foreach ($data->properties->timeseries as $key => $value) {
                $weather_data[$key]['air_temperature'] = $value->data->instant->details->air_temperature;
                $weather_data[$key]['wind_speed'] = $value->data->instant->details->wind_speed;
                if(isset($value->data->next_12_hours)){
                    if($value->data->next_12_hours->summary->symbol_code == "clearsky_day"){
                        $weather_data[$key]['next_12_hours_symbol_code'] = "Clear sky day";
                    }elseif($value->data->next_12_hours->summary->symbol_code == "lightrainshowers_day"){
                        $weather_data[$key]['next_12_hours_symbol_code'] = "Light rain showers";
                    }else{
                        $weather_data[$key]['next_12_hours_symbol_code'] = ucfirst($value->data->next_12_hours->summary->symbol_code);
                    }
                }else{
                    $weather_data[$key]['next_12_hours_symbol_code'] = 'N/A';
                }
                
            }
        }
        return view('weather_report', compact('weather_data'));

    }

    public function sendCurlRequest($url){
        $cURLConnection = curl_init();
        $headers = array(
           "User-Agent: wajid",
           "Content-Type: application/json",
        );
        curl_setopt($cURLConnection, CURLOPT_URL, $url);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($cURLConnection);
        $data = json_decode($data);
        
        curl_close($cURLConnection);
        return $data;
    }
}
