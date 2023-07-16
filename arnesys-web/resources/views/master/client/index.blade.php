@extends('layouts.master')

@section('title', 'Dashboard')

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
                                    <button id="addModalBtn" class="btn btn-success" style="float: right; margin-top: -5px;">Register Client</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Author</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Function</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Employed</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3"
                                                            alt="user2">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Alexa Liras</h6>
                                                        <p class="text-xs text-secondary mb-0">alexa@creative-tim.com</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">Programator</p>
                                                <p class="text-xs text-secondary mb-0">Developer</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">11/01/19</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('client.field', 123) }}" class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3"
                                                            alt="user4">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Michael Levi</h6>
                                                        <p class="text-xs text-secondary mb-0">michael@creative-tim.com</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">Programator</p>
                                                <p class="text-xs text-secondary mb-0">Developer</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">Online</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">24/12/08</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('client.field', 123) }}" class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registerClientModal" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel"
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

    $("#addModalBtn").click(function () {
        $("#registerClientModal").modal("show")
    })

    $(".btnClose").click(function () {
        $("#registerClientModal").modal("hide")
    })

</script>
@endpush
