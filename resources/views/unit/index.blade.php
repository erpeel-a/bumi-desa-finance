@extends('layouts.app')

@push('header-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.7/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Daftar Unit</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Unit</li>
    </ol>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCreateUnit">
        Tambah
    </button>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="units-table">
                    <thead>
                        <tr>
                            <th width="7%">No</th>
                            <th>Unit</th>
                            <th>Dibuat oleh</th>
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
<!-- Modal -->
<div class="modal fade" id="modalCreateUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCreateUnit">
                    @csrf
                    <div class="form-group">
                        <label>Nama Unit</label>
                        <input type="text" class="form-control" name="name" id="name" autofocus>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="storeUnit()">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.7/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var unitsTable = $('#units-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('units.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'created_by', name: 'created_by'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
    });
    $("#formCreateUnit").submit(function(event){
        Swal.fire(
            'Good job!',
            'You clicked the button!',
            'success'
        )
        event.preventDefault();
    });

    function storeUnit() {
        $.ajax({
            url: "{{ route('units.store') }}",
            dataType: 'json',
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                name: $('#modalCreateUnit #name').val()
            },
            success: function( res ){
                if (res.success) {
                    console.log(res);
                    $('#formCreateUnit').trigger("reset");
                    $('#modalCreateUnit').modal('hide');
                    Swal.fire('Unit berhasil disimpan!', null, 'success')
                    window.LaravelDataTables["#units-table"].ajax.reload();
                } else {
                    console.log('failed');
                    $('#modalCreateUnit').find('.modal-body').prepend('<div class="alert alert-danger"><strong>Whoops!</strong> ' + res.errors.name + '.</div>');
                }
            }
        });
    }
</script>
@endpush