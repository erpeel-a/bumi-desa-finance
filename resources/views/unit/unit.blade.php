@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">{{ $unit->name }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $unit->name }}</li>
    </ol>
    <button type="button" class="btn btn-primary mb-3" id="btn_open_modal">
        Tambah
    </button>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="units-table">
                    <thead>
                        <tr>
                            <th width="7%">No</th>
                            <th>Catatan</th>
                            <th>Tanggal</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th>Saldo</th>
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