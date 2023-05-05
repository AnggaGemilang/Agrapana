@extends('layouts.layout')

@section('title','Plant List')

@section('breadcrumb-content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">
            Dashboard
        </li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">
            Plant List
        </li>
    </ol>
    <h6 class="font-weight-bolder text-white mb-0">Plant List</h6>
</nav>

@endsection

@section('content')

<div class="row">
    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers" style="min-height: 100px;">
                            <p class="text-md mb-0 text-capitalize font-weight-bold">Plants Has Been <br> Planted</p>
                            <h4 class="font-weight-bolder mt-2">
                                {{ count($ref) }} data
                            </h4>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
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
                        <div class="numbers" style="min-height: 100px;">
                            <p class="text-md mb-0 text-capitalize font-weight-bold">Plants Fail <br> Planted</p>
                            <h4 class="font-weight-bolder mt-2">
                                {{ count($refFailPlanted) }} data
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
                        <div class="numbers" style="min-height: 100px;">
                            <p class="text-md mb-0 text-capitalize font-weight-bold">Plants Success Harvested</p>
                            <h4 class="font-weight-bolder mt-2">
                                {{ count($refSuccessPlanted) }} data
                            </h4>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-danger shadow-success text-center rounded-circle">
                            <i class="ni ni-tablet-button text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-7 mb-lg-0 mb-4">
        <h5 class="text-number-of-data" style="color: white; font-weight: 700;">Shows {{ count($ref) }} plant data</h5>
    </div>
</div>
<div class="row btn-type" style="margin-top: 30px;">
    <div class="col">
        <button class="btn btn-outline-success w-100">Fruit</button>
    </div>
    <div class="col">
        <button class="btn btn-outline-success w-100">Microgreen</button>
    </div>
    <div class="col">
        <button class="btn btn-outline-success w-100">Ornamental</button>
    </div>
    <div class="col">
        <button class="btn btn-success w-100">Vegetable</button>
    </div>
</div>
<div class="row">
    <div class="col-12 not-found">
        <p>Data Not Found</p>
    </div>
</div>
<div class="row data-plant" style="margin-left: -10px !important;">
    @foreach ($ref as $r)
        <div class="col-3" style="margin-left: 10px; margin-right: 10px; background: white; border-radius: 10px; box-shadow: 0 0 12px 2px rgba(0, 0, 0, 0.020); padding: 25px 20px">
            <div style="display: flex; justify-content: center;">
                <img src="{{ $r['imgUrl'] }}" alt="" style="width: 150px;">
            </div>
            <h5 class="mb-0 mt-2"><b>{{ $r['plantType'] }}</b></h5>
            <p class="mb-0 mt-1 parameter-preset">Mode: {{ $r['mode'] }}</p>
            <p class="mb-0 parameter-preset">Plant Started: {{ $r['plantStarted'] }}</p>
            <p class="mb-0 parameter-preset">Plant Ended: {{ $r['plantEnded'] }}</p>
        </div>
    @endforeach
</div>
@endsection

@push('js')
<script>

    $('.btn-type .col button').click(function(){

        var query_val = $(this).text()

        $('.btn-type .col button').each(function(i) {
            $(this).removeClass("btn-success").addClass("btn-outline-success")
        })

        $.ajax({
            url: '{{ route("monitoring.plant.get") }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                category: query_val
            },
            success: function (data) {
                $('.not-found').css('display','none')
                $('.data-plant').css('display','flex')
                $('.data-plant').children().remove()

                $('.text-number-of-data').text(`Shows ${Object.keys(data).length} plant data`)

                $.each(data, function (key, value) {

                    $('.data-plant')
                        .append(
                            $('<div class="col-3" style="margin-left: 10px; margin-right: 10px; background: white; border-radius: 10px; box-shadow: 0 0 12px 2px rgba(0, 0, 0, 0.020); padding: 25px 20px">')
                                .append(
                                    $('<div style="display: flex; justify-content: center;">')
                                        .append(
                                            $('<img src="' + value.imgUrl + '" alt="" style="width: 150px;">')
                                        )
                                )
                                .append(
                                    $('<h5 class="mb-0 mt-2"><b>' + value.plantType + '</b></h5>')
                                )
                                .append(
                                    $('<p class="mb-0 mt-1 parameter-preset">Mode: ' + value.mode + '</p>')
                                )
                                .append(
                                    $('<p class="mb-0 parameter-preset">Plant Started: ' + value.plantStarted + '</p>')
                                )
                                .append(
                                    $('<p class="mb-0 parameter-preset">Plant Ended: ' + value.plantEnded + '</p>')
                                )
                        )

                })

            },
            error: function (data) {
                $('.not-found').css('display','flex')
                $('.data-plant').css('display','none')
            },
        })
        $(this).removeClass("btn-outline-success").addClass("btn-success")

    })

</script>
@endpush
