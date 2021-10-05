@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Daftar Unit</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Unit</li>
    </ol>
    <button type="button" class="btn btn-primary mb-3" id="btn_open_modal">
        Tambah
    </button>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="units-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="7%">No</th>
                            <th>Nama Unit</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Input Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCreateUnit">
                    <div class="form-group">
                        <label>Nama Unit</label>
                        <input type="hidden" class="form-control" name="id" id="id">
                        <input type="text" class="form-control" name="name" id="name" autofocus>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="saveUnit()">Simpan</button>
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

        $('#btn_open_modal').on('click', function(){
            $('#modalCreateUnit').modal('show')
        })

    });

    var unitsTable = $('#units-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('units.index') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    function saveUnit() {
        let name = $('#name').val();
        let id = $('#id').val();
        $.ajax({
            url: "{{ route('units.store') }}",
            dataType: 'json',
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                name,
                id
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data Unit Berhasil Disimpan',
                        icon: 'success',
                    }).then(function () {
                        clearForm()
                        $('#modalCreateUnit').modal('hide');
                    })
                    unitsTable.ajax.reload();
                } else {
                    toastr["error"](res.errors.name, "Kesalahan Input Data")
                }
            }
        });
    }

    function destroyUnit(params) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Untuk menghapus data unit ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/units/" + params,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire('Terhapus!', 'Unit berhasil dihapus.', 'success');
                            unitsTable.ajax.reload();
                        }
                    }
                });
            }
        })
    }


    function OpenDetailUnit(params) {
        clearForm()
        $.ajax({
            url: "{{ route('show.units') }}",
            dataType: 'json',
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                id: params
            },
            success: function (response) {
                if (response.success) {
                    $('#name').val(response.data.name)
                    $('#id').val(response.data.id)
                    $('#modalCreateUnit').modal('show');
                }
            }
        });
    }


    function clearForm() {
        $('#formCreateUnit')[0].reset()
        $('#name').val('')
        $('#id').val('')
    }

</script>
@endpush
