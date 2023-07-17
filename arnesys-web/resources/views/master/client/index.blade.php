@extends('layouts.master')

@section('title', 'Clients')

@section('breadcrumb-content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-white" href="javascript:;">Pages
                </a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                Client
            </li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0">Client</h6>
    </nav>

@endsection

@section('content')

    <div class="row content-wrapper mt-3">
        <div class="col-xl-12 col-sm-12">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col">
                                    <h6>Clients Data</h6>
                                </div>
                                <div class="col text-end">
                                    <a href="{{ route('client.create') }}" class="btn btn-outline-success" style="float: right; margin-top: -5px;">Register New Client</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Number of Fields
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Client Created
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $row)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img
                                                                @if ($row->photo == NULL)
                                                                    src="{{ asset('assets') }}/img/team-3.jpg"
                                                                @else
                                                                    src="{{ $row->photo }}"
                                                                @endif
                                                                class="avatar avatar-sm me-3" alt="user2">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $row->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs text-secondary mb-0">{{ $row->number_of_fields }} Fields</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs text-secondary mb-0">{{ $row->email }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $row->created_at }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex justify-content-center">
                                                        <a class="btn btn-link text-success text-gradient px-3 mb-0" href="javascript:;"><i class="fas fa-plus me-2"></i></a>
                                                        <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i></a>
                                                        <a class="btn btn-link text-dark text-gradient px-3 mb-0" href="{{ route('client.field', $row->id) }}"><i class="fas fa-arrow-right me-2"></i><span></span></a>
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

    <div class="modal fade" id="addNewFieldModal" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add Preset</h5>
                    <span type="button" class="btnClose" style="font-size: 20px;">&times;</span>
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
                                <input type="text" class="form-control" id="plantName"
                                    placeholder="Masukkan Nama Status ..." name="plant_name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="plantName">Ph</label>
                                <input type="text" class="form-control" id="plantName"
                                    placeholder="Masukkan Nama Status ..." name="plant_name">
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
                                <input type="text" class="form-control" id="plantName"
                                    placeholder="Masukkan Nama Status ..." name="plant_name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="plantName">CO2 Value</label>
                                <input type="text" class="form-control" id="plantName"
                                    placeholder="Masukkan Nama Status ..." name="plant_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="plantName">Seedling Time</label>
                                <input type="text" class="form-control" id="plantName"
                                    placeholder="Masukkan Nama Status ..." name="plant_name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="plantName">Grow Time</label>
                                <input type="text" class="form-control" id="plantName"
                                    placeholder="Masukkan Nama Status ..." name="plant_name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btnClose btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" id="addBtn" class="btn btn-success">Tambah Data</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>

    $("#addFieldModalBtn").click(function () {
        $("#addNewFieldModal").modal("show")
    })

    $(".btnClose").click(function () {
        $("#addNewFieldModal").modal("hide")
    })

</script>
@endpush
