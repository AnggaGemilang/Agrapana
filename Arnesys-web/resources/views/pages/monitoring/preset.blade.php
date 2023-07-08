@extends('layouts.layout')

@section('title','Presets')

@section('breadcrumb-content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">
            Dashboard
        </li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">
            Presets
        </li>
    </ol>
    <h6 class="font-weight-bolder text-white mb-0">Presets</h6>
</nav>

@endsection

@section('content')

<div class="row">
    <div class="col-xl-6 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers" style="min-height: 100px;">
                            <p class="text-md mb-0 text-capitalize font-weight-bold">Number of <br> Presets Type</p>
                            <h4 class="font-weight-bolder mt-2">
                                4 data
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
    <div class="col-xl-6 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers" style="min-height: 100px;">
                            <p class="text-md mb-0 text-capitalize font-weight-bold">Number of <br> Presets</p>
                            <h4 class="font-weight-bolder mt-2">
                                {{ count($ref) }} datas
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
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-7 mb-lg-0 mb-4">
        <h5 class="text-number-of-data" style="color: white; font-weight: 700;">Shows {{ count($ref) }} preset data</h5>
    </div>
    <div class="col-lg-5">
        <button id="addModalBtn" class="btn btn-success" style="float: right; margin-top: -5px;">Add Preset Data</button>
        <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Add Preset</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="plantName">Plant Name</label>
                            <input type="text" class="form-control" id="plantName" placeholder="Masukkan Nama Status ..."
                                name="plant_name">
                        </div>
                        <div class="form-group">
                            <label for="plantCategory">Plant Category</label>
                            <select class="form-select" id="plantCategory" name="plant_category">
                                <option value="">Choose Plant Category</option>
                                <option value="fruit">Fruit</option>
                                <option value="microgreen">Microgreen</option>
                                <option value="ornamental">Ornamental</option>
                                <option value="vegetable">Vegetable</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="batasAtas">Default Image</label>
                            <input type="file" class="form-control" id="batasAtas" placeholder="Masukkan Batas Atas ..."
                                name="batas_atas">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="plantName">Nutrition</label>
                                    <input type="text" class="form-control" id="plantName" placeholder="Masukkan Nama Status ..."
                                        name="plant_name">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="plantName">Ph</label>
                                    <input type="text" class="form-control" id="plantName" placeholder="Masukkan Nama Status ..."
                                        name="plant_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="plantName">Growth Lamp</label>
                                    <select class="form-select" id="plantCategory" name="plant_category">
                                        <option value="">Choose State</option>
                                        <option value="on">On</option>
                                        <option value="off">Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="plantName">Pump</label>
                                    <select class="form-select" id="plantCategory" name="plant_category">
                                        <option value="">Choose State</option>
                                        <option value="on">On</option>
                                        <option value="off">Off</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="plantName">Temperature</label>
                                    <input type="text" class="form-control" id="plantName" placeholder="Masukkan Nama Status ..."
                                        name="plant_name">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="plantName">CO2 Value</label>
                                    <input type="text" class="form-control" id="plantName" placeholder="Masukkan Nama Status ..."
                                        name="plant_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="plantName">Seedling Time</label>
                                    <input type="text" class="form-control" id="plantName" placeholder="Masukkan Nama Status ..."
                                        name="plant_name">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="plantName">Grow Time</label>
                                    <input type="text" class="form-control" id="plantName" placeholder="Masukkan Nama Status ..."
                                        name="plant_name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closeBtn" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" id="addBtn" class="btn btn-success">Tambah Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row btn-type" style="margin-top: 15px;">
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
<div class="row data-preset">
    @foreach ($ref as $r)
        <div class="col-3" style="margin-left: 10px; margin-right: 10px; background: white; border-radius: 10px; box-shadow: 0 0 12px 2px rgba(0, 0, 0, 0.020); padding: 25px 20px">
            <div style="display: flex; justify-content: center;">
                <img src="{{ $r['imageUrl'] }}" alt="" style="width: 150px;">
            </div>
            <h5 class="mb-0 mt-2"><b>{{ $r['plantName'] }}</b></h5>
            <p class="mb-0 mt-1 parameter-preset">Nutrition: {{ $r['nutrition'] }}</p>
            <p class="mb-0 parameter-preset">Ph: {{ $r['ph'] }}</p>
            <p class="mb-0 parameter-preset">Growth Lamp: {{ $r['growthLamp'] }}</p>
            <p class="mb-0 parameter-preset">Gas CO2: {{ $r['gasValve'] }}</p>
            <p class="mb-0 parameter-preset">Temperatur: {{ $r['temperature'] }}</p>
            <p class="mb-0 parameter-preset">Pump: {{ $r['pump'] }}</p>
            <p class="mb-0 parameter-preset">Seedling Time: {{ $r['seedlingTime'] }} Days</p>
            <p class="mb-0 parameter-preset">Grow Time: {{ $r['growTime'] }} Days</p>
        </div>
    @endforeach
</div>
@endsection

@push('js')
<script>

    $("#addModalBtn").click(function () {
        $("#add-modal").modal("show")
    })

    $('.btn-type .col button').click(function(){

        var query_val = $(this).text()

        $('.btn-type .col button').each(function(i) {
            $(this).removeClass("btn-success").addClass("btn-outline-success")
        })

        $.ajax({
            url: '{{ route("monitoring.preset.get") }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                category: query_val
            },
            success: function (data) {
                $('.not-found').css('display','none')
                $('.data-preset').css('display','flex')
                $('.data-preset').children().remove()

                $('.text-number-of-data').text(`Shows ${Object.keys(data).length} plant data`)

                $.each(data, function (key, value) {
                    $('.data-preset')
                        .append(
                            $('<div class="col-3" style="margin-left: 10px; margin-right: 10px; background: white; border-radius: 10px; box-shadow: 0 0 12px 2px rgba(0, 0, 0, 0.020); padding: 25px 20px">')
                                .append(
                                    $('<div style="display: flex; justify-content: center;">')
                                        .append(
                                            $('<img src="' + value.imageUrl + '" alt="" style="width: 150px;">')
                                        )
                                )
                                .append(
                                    $('<h5 class="mb-0 mt-2"><b>' + value.plantName + '</b></h5>')
                                )
                                .append(
                                    $('<p class="mb-0 mt-1 parameter-preset">Nutrition: ' + value.nutrition + '</p>')
                                )
                                .append(
                                    $('<p class="mb-0 parameter-preset">Ph: ' + value.ph + '</p>')
                                )
                                .append(
                                    $('<p class="mb-0 parameter-preset">Growth Lamp: ' + value.growthLamp + '</p>')
                                )
                                .append(
                                    $('<p class="mb-0 parameter-preset">Gas CO2: ' + value.gasValve + '</p>')
                                )
                                .append(
                                    $('<p class="mb-0 parameter-preset">Temperatur: ' + value.temperature + '</p>')
                                )
                                .append(
                                    $('<p class="mb-0 parameter-preset">Pump: ' + value.pump + '</p>')
                                )
                                .append(
                                    $('<p class="mb-0 parameter-preset">Seedling Time: ' + value.seedlingTime + ' Days</p>')
                                )
                                .append(
                                    $('<p class="mb-0 parameter-preset">Pump: ' + value.pump + '</p>')
                                )
                        )
                })

            },
            error: function (data) {
                $('.not-found').css('display','flex')
                $('.data-preset').css('display','none')
                $('.text-number-of-data').text(`Shows 0 preset data`)
            },
        })
        $(this).removeClass("btn-outline-success").addClass("btn-success")

    })

</script>
@endpush
