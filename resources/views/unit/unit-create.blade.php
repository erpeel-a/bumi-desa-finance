@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Input {{ $unit->name }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Unit</li>
        <li class="breadcrumb-item active">{{ $unit->name }}</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('unit.store', $unit->slug) }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" max="{{ Carbon\Carbon::now()->toDateString() }}">
                        @error('date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="income" class="col-sm-2 col-form-label">Pemasukan</label>
                    <div class="col-sm-10">
                        <input type="number" name="income" class="form-control @error('income') is-invalid @enderror" id="income" min="0" value="0">
                        @error('income')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="expense" class="col-sm-2 col-form-label">Pengeluaran</label>
                    <div class="col-sm-10">
                        <input type="number" name="expense" class="form-control @error('expense') is-invalid @enderror" id="expense" min="0" value="0">
                        @error('expense')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Catatan</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary ml-auto">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection