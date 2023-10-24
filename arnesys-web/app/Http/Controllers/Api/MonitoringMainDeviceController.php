<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\MonitoringMainDevice;
use App\Models\MonitoringSupportDevice;
use Illuminate\Http\Request;

class MonitoringMainDeviceController extends Controller
{
    public function store(Request $request)
    {
        return MonitoringMainDevice::create($request->all());
    }

    public function show($id)
    {
        $monitoringMainDevice = MonitoringMainDevice::where('field_id', $id)->paginate(5);
        return $monitoringMainDevice;
    }

    public function getChartData($id, $column, $type)
    {
        $monitoringMainDevice = [];
        if($type == "latest"){
            $monitoringMainDevice = MonitoringMainDevice::select($column . " AS value", 'created_at', DB::raw('YEAR(created_at) AS time'))
                ->where('field_id', $id)
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        } else if($type == "hour"){
            $monitoringMainDevice = MonitoringMainDevice::select($column . " AS value", 'created_at', DB::raw('HOUR(created_at) AS time'))
                ->where('field_id', $id)
                ->groupBy(DB::raw('HOUR(created_at)'))
                ->paginate(10);
        } else {
            $monitoringMainDevice = MonitoringMainDevice::select($column . " AS value", 'created_at', DB::raw('DAY(created_at) AS time'))
                ->where('field_id', $id)
                ->groupBy(DB::raw('DAY(created_at)'))
                ->paginate(10);
        }
        return $monitoringMainDevice;
    }

    function getPestPrediction($id)
    {
        $meanDailyMaxAirTemp = MonitoringMainDevice::select([DB::raw('MAX(wind_temperature) AS highest')])
            ->where('field_id', $id)
            ->where( 'created_at', '>', date('Y-m-d H:i:s', strtotime("-3 days")))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->pluck('highest')->avg();

        $maxAirTempMeasured = MonitoringMainDevice::where('field_id', $id)
            ->max('wind_temperature');

        $meanDailyMinAirTemp = MonitoringMainDevice::select([DB::raw('MIN(wind_humidity) AS highest')])
            ->where('field_id', $id)
            ->where( 'created_at', '>', date('Y-m-d H:i:s', strtotime("-3 days")))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->pluck('highest')->avg();

        $minAirTempMeasured = MonitoringMainDevice::where('field_id', $id)
            ->min('wind_temperature');

        $meanDailyMaxGroundTemp = MonitoringSupportDevice::select([DB::raw('MAX(soil_temperature) AS highest')])
            ->where('field_id', $id)
            ->where( 'created_at', '>', date('Y-m-d H:i:s', strtotime("-3 days")))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->pluck('highest')->avg();

        $maxGroundTempMeasured = MonitoringSupportDevice::where('field_id', $id)
            ->max('soil_temperature');

        $meanDailyMinGroundTemp = MonitoringSupportDevice::select([DB::raw('MIN(soil_humidity) AS highest')])
            ->where('field_id', $id)
            ->where( 'created_at', '>', date('Y-m-d H:i:s', strtotime("-3 days")))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->pluck('highest')->avg();

        $minGroundTempMeasured = MonitoringSupportDevice::where('field_id', $id)
            ->min('soil_temperature');

        $meanDailyMaxHumidity = MonitoringMainDevice::select([DB::raw('MIN(wind_humidity) AS highest')])
            ->where('field_id', $id)
            ->where('created_at', '>', date('Y-m-d H:i:s', strtotime("-3 days")))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->pluck('highest')->avg();

        $maxHumidityMeasured = MonitoringMainDevice::where('field_id', $id)
            ->max('wind_humidity');

        return response()->json([
            "sensor_data" => [
                doubleval($meanDailyMaxAirTemp),
                doubleval($maxAirTempMeasured),
                doubleval($meanDailyMinAirTemp),
                doubleval($minAirTempMeasured),
                doubleval($meanDailyMaxGroundTemp),
                doubleval($maxGroundTempMeasured),
                doubleval($meanDailyMinGroundTemp),
                doubleval($minGroundTempMeasured),
                doubleval($meanDailyMaxHumidity),
                doubleval($meanDailyMaxHumidity)
            ]
        ], 200);

    }

}
