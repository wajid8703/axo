@extends('layouts.app')

@section('content')
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Weather Report</h2></div>
                </div>
            </div>
   
            <table class="table table-striped table-hover table-bordered weather_table">
                <thead>
                    <tr>
                        <th>Air Temperature</th>
                        <th>Wind Speed</th>
                        <th>Next 12 Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($weather_data as $key => $value)
                        <tr>
                            <td>{{ $value['air_temperature']}}</td>
                            <td>{{ $value['wind_speed']}}</td>
                            <td>{{ $value['next_12_hours_symbol_code']}}</td>
                        </tr>
                    @endforeach
                </tbody>
 
            </table>
        </div>
    </div>  
</div>   
<script type="text/javascript">   
   $(document).ready(function () {   
      $('.weather_table').dataTable({  
      });   
   });   
</script>
@endsection
