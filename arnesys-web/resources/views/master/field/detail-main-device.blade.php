@extends('layouts.master')

@section('title', 'Detail Main Device')

@section('breadcrumb-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-white" href="javascript:;">Pages</a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                @hasrole('Operator')
                    <a class="opacity-5 text-white" href="{{ route('client.field', $field->client_id) }}">Field</a>
                @endrole
                @hasrole('Client')
                    <a class="opacity-5 text-white" href="{{ route('field') }}">Field</a>
                @endrole
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                Detail
            </li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0">Detail Main Device</h6>
    </nav>
@endsection

@section('content')
    <div class="row content-wrapper mt-3" style="padding-bottom: 70px;">
        <div class="col-xl-12 col-sm-12">
            <div class="row">
                <div class="col-4">
                    <div class="card" style="height: 100%;">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-6" style="padding-right: 0px !important;">
                                    <div class="numbers" style="min-height: 93px;">
                                        <p class="mb-0 text-capitalize font-weight-bold" style="font-size: 13pt;">Weather
                                            Condition</p>
                                        <img src="{{ asset('assets') }}/img/spinach.png" alt=""
                                            style="margin-top: 9px; width: 155px;">
                                    </div>
                                </div>
                                <div class="col-6 text-end" style="padding-left: 0px !important;">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="ni ni-bell-55 text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                    <p class="mb-0 text-capitalize" style="margin-top: 48px; font-size: 11pt;">
                                        Wind Speed
                                    </p>
                                    <h4 id="txtPlantName" class="mb-0 text-capitalize font-weight-bolder"
                                        style="font-size: 14pt;">
                                        7 mph
                                    </h4>
                                    <p class="mb-0 text-capitalize" style="font-size: 11pt; margin-top: 15px;">
                                        Wind Pressure
                                    </p>
                                    <h4 id="txtStartedPlant" class="mb-0 text-capitalize font-weight-bolder"
                                        style="font-size: 14pt;">
                                        13
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers" style="min-height: 93px;">
                                                <p class="text-md mb-0 text-capitalize font-weight-bold">Warmth <br>
                                                    Value</p>
                                                <h4 id="txtTemperature" class="font-weight-bolder mt-2">
                                                    25&deg;
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-danger shadow-success text-center rounded-circle">
                                                <i class="ni ni-bulb-61 text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers" style="min-height: 93px;">
                                                <p class="text-md mb-0 text-capitalize font-weight-bold">Humidity <br> Value
                                                </p>
                                                <h4 id="txtPh" class="font-weight-bolder mt-2">
                                                    20%
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-warning shadow-success text-center rounded-circle">
                                                <i class="ni ni-folder-17 text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers" style="min-height: 93px;">
                                                <p class="text-md mb-0 text-capitalize font-weight-bold">Pests <br>
                                                    Forecast</p>
                                                <h4 id="txtNutrition" class="font-weight-bolder mt-2">
                                                    Safe
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-danger shadow-success text-center rounded-circle">
                                                <i class="ni ni-square-pin text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers" style="min-height: 93px;">
                                                <p class="text-md mb-0 text-capitalize font-weight-bold">Light <br>
                                                    Intensity
                                                </p>
                                                <h4 id="txtLamp" class="font-weight-bolder mt-2">
                                                    1000
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow-success text-center rounded-circle">
                                                <i class="ni ni-istanbul text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <h5>Histories Data</h5>
            </div>
            <div class="row" style="margin-top: 15px;">
                <div class="col-xl-12 col-sm-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active " role="tab" aria-selected="true" href="#1"
                                data-toggle="tab">
                                <span class="text-success text-bold size">Weather</span>
                            </a>
                            <a class="nav-item nav-link " href="#1" role="tab" aria-selected="false"
                                data-toggle="tab">
                                <span class="text-success text-bold size">Pests</span>
                            </a>
                            <a class="nav-item nav-link " href="#1" role="tab" aria-selected="false"
                                data-toggle="tab">
                                <span class="text-success text-bold size">Warmth</span>
                            </a>
                            <a class="nav-item nav-link " href="#1" role="tab" aria-selected="false"
                                data-toggle="tab">
                                <span class="text-success text-bold size">Humidity</span>
                            </a>
                            <a class="nav-item nav-link " href="#1" role="tab" aria-selected="false"
                                data-toggle="tab">
                                <span class="text-success text-bold size">Wind Speed</span>
                            </a>
                            <a class="nav-item nav-link " href="#1" role="tab" aria-selected="false"
                                data-toggle="tab">
                                <span class="text-success text-bold size">Wind Pressure</span>
                            </a>
                            <a class="nav-item nav-link " href="#1" role="tab" aria-selected="false"
                                data-toggle="tab">
                                <span class="text-success text-bold size">Light Intensity</span>
                            </a>
                        </div>
                    </nav>
                    <div class="tab-content">
                        <div class="tab-pane active bg-white" id="1">
                            <div class="row">
                                <div class="col">
                                    <h4 id="valDataType">Weather</h4>
                                </div>
                                <div class="col d-flex justify-content-end">
                                    <select class="form-select" style="width: 200px;">
                                        <option selected>Last Time</option>
                                        <option value="1">Per 2 Hour</option>
                                        <option value="2">Per data</option>
                                    </select>
                                </div>
                            </div>
                            <canvas id="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .tab-content {
            border-bottom: 1px solid #DEE2E6;
            border-left: 1px solid #DEE2E6;
            border-right: 1px solid #DEE2E6;
        }

        .tab-pane {
            padding-left: 75px;
            padding-right: 65px;
            padding-top: 50px;
            padding-bottom: 50px;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets/js/mqtt.js') }}"></script>

    <script>

        var ctx = document.getElementById("chart")

        function closeLoader(){
            $(".loader").hide()
            $("body").css("overflow-y", "auto")
            MQTTconnect()
        }

        $(document).ready(function() {
            showChart()
            closeLoader()
        })

        $(".nav-link").click(function() {
            const title = $(this).find("span").text()
            $("#valDataType").text(title)
            showChart()
        })

        function showChart(){
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1/3/2023', '1/10/2023', '1/17/2023', '1/24/2023'],
                    datasets: [{
                        label: 'Number of Leaves',
                        data: [3, 5, 7, 10],
                        backgroundColor: [
                            '#66BB6A',
                        ],
                        borderColor: [
                            '#66BB6A',
                        ],
                        borderWidth: 1
                    }]
                },
            })
        }

    </script>

</script>
@endpush
