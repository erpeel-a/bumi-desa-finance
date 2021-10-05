@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">{{ $unit->name }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Unit</li>
        <li class="breadcrumb-item active">{{ $unit->name }}</li>
    </ol>
    @if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <a href="{{ route('unit.create', $unit->slug) }}" class="btn btn-primary mb-3">
        Tambah
    </a>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="unit-report-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="7%">No</th>
                            <th>Catatan</th>
                            <th>Tanggal</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th width="7%" class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    var unitReportTable = $('#unit-report-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('unit.index', $unit->slug) }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'income',
                name: 'income'
            },
            {
                data: 'expense',
                name: 'expense'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
</script>
@endpush