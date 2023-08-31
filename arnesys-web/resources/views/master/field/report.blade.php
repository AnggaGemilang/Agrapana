@extends('layouts.master')

@section('title', 'Monitoring')

@section('breadcrumb-content')
  <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-white" href="javascript:;">
                    Pages
                </a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                Monitoring
            </li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0">Report</h6>
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
                                    <h6>Report</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Case
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Treatment Suggestion
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                        <td align="middle">
                                            <p>ph rendah</p>
                                        </td>
                                        <td align="middle">
                                            <p>Tambahkan pupuk dengan senyawa basa tinggi</p>
                                        </td>
                                        <td align="middle">
                                            <div class="d-flex justify-content-center">
                                                @hasrole('Operator')
                                                    <form action="" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="btn btn-link text-danger text-gradient px-3 mb-0 tolak-btn">
                                                            Tolak
                                                        </button>
                                                    </form>
                                                @endrole
                                                <button class="btn btn-link detail-btn text-dark text-gradient px-3 mb-0">
                                                    <span>Lakukan</span>
                                                </button>
                                            </div>
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

    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Berikan feedback sebelum tolak</h5>
                    <span type="button" class="btnClose" style="font-size: 20px;">&times;</span>
                </div>
                <form action="{{ route('field.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Feedback</label>
                            <textarea class="form-control" rows="4" name="feedback" placeholder="Enter feedback . . ."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="client_id" value="">
                        <button type="button" class="btnClose btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Masukan Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>

    $('tr').on('click', '.tolak-btn', function (e){
        $('input[name=client_id]').val($(this))
        $("#feedbackModal").modal("show")
    });

    $('tr').on('click', '.add-field', function() {
        $('input[name=client_id]').val($(this).attr('data-id'))
        $("#feedbackModal").modal("show")
    })

    $(".btnClose").click(function () {
        $("#feedbackModal").modal("hide")
    })

    $(document).ready(function() {
        closeLoader()
    })

</script>
@endpush