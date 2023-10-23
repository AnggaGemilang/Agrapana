@extends('layouts.master')

@section('title', 'Fields')

@section('breadcrumb-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-white" href="javascript:;">
                    Pages
                </a>
            </li>
            @hasrole('Operator')
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                <a class="opacity-5 text-white" href="{{ route('client') }}">
                    Client
                </a>
            </li>
            @endrole
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                Field
            </li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0">Field </h6>
    </nav>
@endsection

@section('content')
    <div class="row content-wrapper mt-3" style="padding-bottom: 70px;">
        <div class="col-xl-12 col-sm-12">
            <div class="row">
                <div class="col-12">
                    <div class="card pb-3">
                        <div class="card-header pb-0">
                            <h6>Fields Data</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Plant Name
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Field Code
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Land Area
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Address
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Number of Support Device
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fields as $row)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img
                                                                @if ($row->thumbnail == NULL)
                                                                    src="{{ asset('assets') }}/img/field.jpg"
                                                                @else
                                                                    src="{{ Storage::url($row->thumbnail) }}"
                                                                @endif
                                                                class="avatar avatar-sm me-3" alt="user2">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $row->plant_type }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $row->id }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $row->address }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $row->land_area }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $row->number_of_support_device }} Support Devices</p>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex justify-content-center">

                                                        @hasrole('Operator')

                                                            <form action="{{ route('field.delete', $row->id) }}" method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="button" class="btn btn-link text-danger text-gradient px-3 mb-0 delete-btn"><i class="far fa-trash-alt me-2"></i></button>
                                                            </form>

                                                        @endrole

                                                        <button class="btn btn-link detail-btn text-dark text-gradient px-3 mb-0">
                                                            <i class="fas fa-arrow-down me-2"></i>
                                                        </button>

                                                        <button plant-type="{{ $row->plant_type }}" field-id="{{ $row->id }}" client-id="{{ $id }}" class="btn btn-link check-btn text-warning text-gradient px-3 mb-0">
                                                            <i class="fas fa-question me-2"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="padding: 0;">
                                                    <div class="detail-elements" style="padding: 10px;">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td colspan="5" style="padding-left: 15px;">
                                                                    <a href="{{ route('client.field.detail.main', $row->id) }}">
                                                                        <div class="pb-1 pt-1 icon-move-right">
                                                                            <span style="margin-bottom: 0; font-size: 15px;" class="link-dark text-bold">Perangkat Utama</span>
                                                                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                                                        </div>
                                                                    </a>
                                                                </td>
                                                            </tr>

                                                            @for ($i = 0; $i < $row->number_of_support_device; $i++)
                                                                <tr>
                                                                    <td colspan="5" style="padding-left: 15px;">
                                                                        <a href="{{ route('client.field.detail.support', ['id' => $row->id, 'number' => $i+1]) }}">
                                                                            <div class="pb-1 pt-1 icon-move-right">
                                                                                <span style="margin-bottom: 0; font-size: 15px;" class="link-dark text-bold">Perangkat Pendukung {{ $i+1 }}</span>
                                                                                <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="seekCropRecommendation" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Detail Crop Recommendation</h5>
                    <span type="button" class="btnClose" style="font-size: 20px;">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="row loader-wrapper mt-5 mb-5">
                        <div class="col d-flex justify-content-center align-items-center">
                            <img src="{{ asset('assets/img/loader/loader3.gif') }}" width="80" alt="">
                        </div>
                    </div>
                    <div class="row item-pest-wrapper">
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-map-big text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-10 d-flex align-items-center">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <h6 style="font-size: 14pt;" id="txt-crop" class="mb-0"></h6>
                                    </div>
                                    <div class="row">
                                        <p style="font-size: 12pt;" id="txt-desc-crop" class="mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btnClose btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')

<style>
    .detail-elements, .item-pest-wrapper {
        display: none;
    }

</style>

@endpush

@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
<script src="{{ asset('assets/js/mqtt.js') }}"></script>
<script>

    var clientId, fieldId
    let nValue, pValue, kValue, temperatureValue, moistureValue, phValue, rainfallValue;

    $('tr').on('click', '.delete-btn', function (e){
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Field would be deleted",
            icon: "warning",
            type: "warning",
            buttons: ["Cancel","Yes!"],
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!'
        }).then((willAccept) => {
            if (willAccept) {
                $(this).parent('form').trigger('submit')
            }
        });
    });

    $('tr').on('click', '.check-btn', function() {
        clientId = $(this).attr('client-id')
        fieldId = $(this).attr('field-id')
        if(nValue == null && pValue == null && kValue == null && temperatureValue == null && moistureValue == null && phValue == null && rainfallValue == null){
            MQTTconnect()
        }
        $("#seekCropRecommendation").modal("show")
    });

    function onMessageArrived(r_message) {
        out_msg = "Message received " + r_message.payloadString + "<br>"
        out_msg = out_msg + "Message received Topic " + r_message.destinationName

        var topic = r_message.destinationName

        if (topic == `arnesys/${fieldId}/pendukung/1`) {
            var data = JSON.parse(r_message.payloadString)

            nValue = data.monitoring.soil_nitrogen
            pValue = data.monitoring.soil_phosphor
            kValue = data.monitoring.soil_kalium
            temperatureValue = data.monitoring.soil_temperature
            moistureValue = data.monitoring.soil_humidity
            phValue = data.monitoring.soil_ph

        } else if (topic == `arnesys/${fieldId}/utama`) {
            var data = JSON.parse(r_message.payloadString)

            console.log(data)

            rainfallValue = data.monitoring.rainfall
        }

        if(nValue != null && pValue != null && kValue != null && temperatureValue != null && moistureValue != null && phValue != null && rainfallValue != null){
            $(".loader-wrapper").hide()
            $(".item-pest-wrapper").css("display","flex")

            MQTTdisconnect()

            const datas = {
                sensor_data: [
                    80.7, // N
                    43.4, // P
                    39.4, // K
                    24.710539, // Suhu
                    82.280899, // Kelembaban
                    6.135331, // ph
                    184.731080, // curah hujan
                ]
            }

            const plantType = $(this).attr("plant-type")

            $.ajax({
                url: "http://127.0.0.1:5000/crop/predict/recommend",
                data: JSON.stringify(datas),
                type: "post",
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                },
                success: function (data){
                    $("#txt-crop").text(data.recommend_crop[0].toUpperCase() + data.recommend_crop.slice(1))

                    if(plantType == data.recommend_crop) {
                        $("#txt-desc-crop").text("Based on the dataset used, the results of AI processing indicate that this land is already suitable for " + data.recommend_crop)
                    } else {
                        $("#txt-desc-crop").text("Based on the dataset used, the results of AI processing indicate that this land is suitable for" + data.recommend_crop + " With the current land being used for " + plantType + ", further studies are needed regarding the suitability of this land for the type of crops to be planted")
                    }
                },
                error: function(data){
                    console.log(data)
                }
            });
        }
    }

    $('tr').on('click', '.detail-btn', function() {
        $(this).closest('tr').next().find('.detail-elements').slideToggle(200, 'linear')
    });

    $(document).ready(function() {
        closeLoader()
    })

</script>

@endpush
