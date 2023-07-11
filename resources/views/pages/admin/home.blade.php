@extends('layouts.layout')

@section('title','Dashboard')

@section('content')

    <div class="page-header" style="margin-bottom: 25px;">
        <h3 class="page-title">Dashboard</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ol>
        </nav>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Visitors</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalVisitor }} Data</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-flag"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Country</h6>
                                        <h6 class="font-extrabold mb-0">{{ count($totalCountry) }} Data</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Booth Visitor By Number</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit">
                                    <canvas id="graphByVisitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Booth Visitor By Country</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit">
                                    <canvas id="graphByCountry"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <style>
        .bi {
            height: 0rem !important;
            width: 0rem !important;
        }
    </style>
@endpush

@push('js')
<script>

    var graphByVisitor = <?php echo $graphByVisitor ?>;

    let labelsGraphByVisitor = []
    let datasGraphByVisitor = []

    graphByVisitor.forEach((x, i) => {
        datasGraphByVisitor.push(x.count)
        labelsGraphByVisitor.push(x.date)
    })

    var ctx = document.getElementById("graphByVisitor")
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsGraphByVisitor,
            datasets: [{
                label: 'Visitor',
                data: datasGraphByVisitor,
                backgroundColor: [
                    '#66BB6A',
                ],
                borderColor: [
                    '#66BB6A',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    gridLines: {
                        offsetGridLines: true
                    }
                },
                {
                    position: "top",
                    gridLines: {
                        offsetGridLines: true
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    })

    var graphByCountry = <?php echo $graphByCountry ?>;

    var labelsGraphByCountry = []
    var datasGraphByCountry = []

    graphByCountry.forEach((x, i) => {
        datasGraphByCountry.push(x.count)
        labelsGraphByCountry.push(x.nicename)
    })

    var ctx = document.getElementById("graphByCountry")
    var myChart2 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsGraphByCountry,
            datasets: [{
                label: 'Country',
                data: datasGraphByCountry,
                backgroundColor: [
                    '#66BB6A',
                ],
                borderColor: [
                    '#66BB6A',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    gridLines: {
                        offsetGridLines: true
                    }
                },
                {
                    position: "top",
                    gridLines: {
                        offsetGridLines: true
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    })

</script>
@endpush
