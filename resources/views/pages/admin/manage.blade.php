@extends('layouts.layout')

@section('title','Manage')

@section('content')

    <div class="page-header" style="margin-bottom: 25px;">
        <h3 class="page-title">Manage</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Manage</a></li>
            </ol>
        </nav>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col" style="padding-top: 10px;">
                                <h4 id="jumlah_data">Menampilkan {{ count($presence) }} Data</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover data-table text-center" id="manage-data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Sekolah</th>
                                    <th>Pendapat</th>
                                    <th>Waktu</th>
                                    <th>Tanda Tangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach ($presence as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td>{{ $i++; }}</td>
                                    <td>{{ $data->full_name; }}</td>
                                    <td>{{ $data->school; }}</td>
                                    <td>{{ $data->opinion; }}</td>
                                    <td>{{ $data->created_at; }}</td>
                                    <td>
                                        <img src="{{ url('uploaded/' . $data->signature); }}" alt="">
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

@endsection

@push('js')
<script>

$(document).ready(function () {
    $('#manage-data').DataTable()
})

</script>
@endpush
