@extends('layouts.master')

@section('title', 'Detail Support Device')

@section('breadcrumb-content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-white" href="javascript:;">Pages
                </a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                <a class="opacity-5 text-white" href="{{ route('client.field',  $field->client_id) }}">Field</a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                Detail
            </li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0">Detail Support Device</h6>
    </nav>

@endsection

@section('content')

<div class="row content-wrapper">
    <div class="col-xl-4 col-sm-6" style="min-height: max-content;">
        <div class="card" style="height: 100%;">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-6" style="padding-right: 0px !important;">
                        <div class="numbers" style="min-height: 93px;">
                            <p class="mb-0 text-capitalize font-weight-bold" style="font-size: 13pt;">Planting Description</p>
                            <img src="{{ asset('assets') }}/img/spinach.png" alt="" style="margin-top: 9px; width: 155px;">
                        </div>
                    </div>
                    <div class="col-6 text-end" style="padding-left: 0px !important;">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                            <i class="ni ni-bell-55 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                        <p class="mb-0 text-capitalize" style="margin-top: 48px; font-size: 11pt;">Plant Name</p>
                        <h4 id="txtPlantName" class="mb-0 text-capitalize font-weight-bolder" style="font-size: 14pt;">Spinach</h4>
                        <p class="mb-0 text-capitalize" style="font-size: 11pt; margin-top: 15px;">Started Planting</p>
                        <h4 id="txtStartedPlant" class="mb-0 text-capitalize font-weight-bolder" style="font-size: 14pt;">5 Apr 23 13:00</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-sm-10">
        <div class="row">
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Temperature <br> Value</p>
                                    <h4 id="txtTemperature" class="font-weight-bolder mt-2">
                                        25&deg;
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-success text-center rounded-circle">
                                    <i class="ni ni-bulb-61 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Ph Meter <br> Value</p>
                                    <h4 id="txtPh" class="font-weight-bolder mt-2">
                                        7 Ph
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-success text-center rounded-circle">
                                    <i class="ni ni-folder-17 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Gas CO2 <br> Value</p>
                                    <h4 id="txtGas" class="font-weight-bolder mt-2">
                                        620 PPM
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-success text-center rounded-circle">
                                    <i class="ni ni-support-16 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Nutrition <br> Value</p>
                                    <h4 id="txtNutrition" class="font-weight-bolder mt-2">
                                        678 PPM
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-success text-center rounded-circle">
                                    <i class="ni ni-square-pin text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Volume <br> Value</p>
                                    <h4 id="txtVolume" class="font-weight-bolder mt-2">
                                        60 %
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Growth Lamp <br> Status</p>
                                    <h4 id="txtLamp" class="font-weight-bolder mt-2">
                                        On
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-success text-center rounded-circle">
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
<div class="row content-wrapper mt-4">
    <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">The Number of Leaves</h6>
                <p class="text-md mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="font-weight-bold">2.3% more</span> long growth
                </p>
            </div>
            <div class="card-body p-3">
                <div class="box">
                    <canvas id="numberOfLeaves"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">The Number of Leaves</h6>
                <p class="text-md mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="font-weight-bold">2.3% more</span> long growth
                </p>
            </div>
            <div class="card-body p-3">
                <div class="box">
                    <canvas id="numberOfLeaves2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>

<script>

    var ctx = document.getElementById("numberOfLeaves")
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1/3/2023', '1/10/2023', '1/17/2023', '1/24/2023'],
            datasets: [
                {
                    label: 'Number of Leaves',
                    data: [3, 5, 7, 10],
                    backgroundColor: [
                        '#66BB6A',
                    ],
                    borderColor: [
                        '#66BB6A',
                    ],
                    borderWidth: 1
                }
            ]
        },
    })

    var ctx2 = document.getElementById("numberOfLeaves2")
    var myChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['1/3/2023', '1/10/2023', '1/17/2023', '1/24/2023'],
            datasets: [
                {
                    label: 'Number of Leaves',
                    data: [3, 5, 7, 10],
                    backgroundColor: [
                        '#66BB6A',
                    ],
                    borderColor: [
                        '#66BB6A',
                    ],
                    borderWidth: 1
                }
            ]
        },
    })

</script>
@endpush
