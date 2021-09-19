@extends('layouts.app')

@push('header-script')
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css') }}">
@endpush

@section('content')
<div class="section-header">
    <h1>Daftar Unit</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item">Master Data</div>
        <div class="breadcrumb-item">Daftar Unit</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">This is Example Page</h2>
    <p class="section-lead">This page is just an example for you to create your own page.</p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" id="modalCreateUnit">Tambah Unit</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-units">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">#</th>
                                    <th>Name</th>
                                    <th width="20%">Dibuat oleh</th>
                                    <th width="5%">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $unit->name }}</td>
                                    <td>{{ $unit->created_by }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <button id="delete-unit" class="dropdown-item" onclick="destroyUnit({{ $unit->id }})">Delete</button>
                                            </div>
                                            {{-- <form id="delete-unit-form" action="{{ route('units.destroy', $unit->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form> --}}
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

<form class="modal-part" id="modal-create-unit-part" method="POST" action="{{ route('units.store') }}">
    @csrf
    <div class="form-group">
        <label>Nama Unit</label>
        <input type="text" class="form-control" name="name" id="name" autofocus>
    </div>
</form>
@endsection

@push('footer-script')
<script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/modules/prism/prism.js') }}"></script>
<script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>

<script>
    $(document).ready( function () {
        $('#table-units').DataTable();
    } );

    $("#modalCreateUnit").fireModal({
        title: 'Tambah Unit',
        body: $("#modal-create-unit-part"),
        footerClass: 'bg-whitesmoke',
        center: true,
        autoFocus: true,
        onFormSubmit: function(modal, e, form) {
            // Form Data
            let form_data = $(e.target).serialize();
            // console.log(form_data)

            // DO AJAX HERE
            let fake_ajax = setTimeout(function() {
                $.ajax({
                    url: "{{ route('units.store') }}",
                    type: "post",
                    data: form_data,
                    success: function (res) {
                        if (res.success) {
                            $.destroyModal(modal);
                            swal('Sukses', 'Unit ' + res.name + ' berhasil ditambahkan', 'success');
                        } else {
                            modal.find('.modal-body').prepend('<div class="alert alert-danger"><strong>Whoops!</strong> ' + res.errors.name + '.</div>');
                        }
                    }
                });
                form.stopProgress();

                clearInterval(fake_ajax);
            }, 1500);

            e.preventDefault();
        },
        shown: function(modal, form) {
            console.log(form);
        },
        buttons: [
            {
                text: 'Simpan',
                submit: true,
                class: 'btn btn-primary btn-shadow',
                handler: function(modal) {
                }
            }
        ]
    });
    
    // function destroyUnit(params) {
    //     var id = params;
    //     swal({
    //         title: 'Apa Anda yakin?',
    //         // text: 'Once deleted, you will not be able to recover this imaginary file!',
    //         icon: 'warning',
    //         buttons: true,
    //         dangerMode: true,
    //     })
    //     .then((willDelete) => {
    //         if (willDelete) {
    //             $.ajax({
    //                 type: 'DELETE',
    //                 url: "{{ route('units.destroy', "id") }}",
    //                 data: {
    //                     _token: "{{ csrf_token() }}",
    //                 },
    //                 success: function (res) {
    //                     if (res.success) {
    //                         swal('Poof! Your imaginary file has been deleted!', {
    //                             icon: 'success',
    //                         });
    //                         location.reload();
    //                     } else {
    //                         swal('Ops!', null, 'error');
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // }
</script>
@endpush