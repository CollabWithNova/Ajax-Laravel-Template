@extends('layouts.main')
@include('riskKriteria.offcanvas')
@include('riskKriteria.offcanvasEdit')
@section('content')
{{-- <h1 class="text-center mb-5">BELAJAR CRUD</h1> --}}
<div class="card">
    <div class="card-body">
        <table class="table" id="datatable">
            <thead>
                <div class="d-flex mb-2 justify-content-between">
                    <span class="mt-1 fs-4">Data Jenis Risk</span>
                    <a class="btn btn-primary  conva" >
                      Tambah Jenis risk
                    </a>                 
                </div>
                <tr style="width: 100px">
                    {{-- <th style="width: 100px">No</th> --}}
                    <th style="width: 100px">Nama</th>
                    <th style="width: 100px">Deskripsi Risk</th>
                    <th style="width: 100px">Level Risk</th>
                    <th style="width: 100px">Status</th>
                    <th style="width: 100px">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
        <script>
          var dataTable;
          $(function() {
            dataTable = $('#datatable').dataTable({
                // contentType: "application/json; charset=utf-8",
                processing: true,
                serverside: true,
                // scrollY: false,
                ajax: "{{ route('risk.Datatable') }}",
                columns: [
                //   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'nama_risk', name: 'Nama'},
                  {data: 'kode_risk', name: 'Nama'},
                  {
                        data: "level_risk",
                        render: function (data) {
                            if (data === '1' ) {
                                return '<span class="badge" style=" width: 90px; border-radius: 4px; color:#F1416C; background: #FFF2F1; box-shadow: -4px 4px 5px 0px #FFF2F1;">High</span>';
                            } else if (data === '2') {
                                return '<span class="badge" style=" width: 90px; border-radius: 4px; color:#FFDA6B; background: #FFFCF5; box-shadow: -4px 4px 5px 0px #FFFCF5;">Medium</span>';
                            } else {
                                return '<span class="badge" style=" width: 90px; border-radius: 4px; color:#50CDA3; background: #E8FFF3; box-shadow: -4px 4px 5px 0px #E8FFF3;">Low</span>';

                            }
                        }
                    },                  {
                        data: "isaktif_risk",
                        render: function (data) {
                            if (data === '1' ) {
                                return '<span class="badge" style=" width: 90px; border-radius: 4px; color:#50CDA3; background: #E8FFF3; box-shadow: -4px 4px 5px 0px #E8FFF3;">Active</span>';
                            } else {
                                return '<span class="badge" style=" width: 90px; border-radius: 4px; color:#F1416C; background: #FFF2F1; box-shadow: -4px 4px 5px 0px #FFF2F1;">In Active</span>';
                            }
                        }
                    },
                  {data: 'action', name: 'aksi'},
                //   {data: '_', searchable: false, orderable: false, class: 'text-center'},

              ]
              });
          });

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

        $('body').on('click','.conva', function(e){
            e.preventDefault();
            $('#offcanvasExampleAdd').offcanvas('show');
            $('.confir').click(function() {
            Swal.fire({
            title: 'Apakah Anda yakin ingin menyimpan data?',
            text: 'Data yang telah disimpan tidak dapat diubah kembali.',
            icon: 'warning',
            showCancelButton: true,
            width: 500,
            confirmButtonColor: '#217AFF',
            // confirmTextButtonColor: '#B9D5FF',
            cancelButtonColor: '#F1416C',
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Simpan data
                        $.ajax({
                            url:'{{ route('risk.store') }}',
                            type:'POST',
                            data: {
                                nama_risk: $('#nama_risk').val(),
                                kode_risk: $('#kode_risk').val(),
                                level_risk: $('#level_risk').val(),
                                isaktif_risk: $('input[name="isaktif_risk"]:checked').val(),
                            },
                            success: function(response) {
                                if (response.errors) {
                                    console.log(response.errors);
                                    // Tampilkan pesan error
                                    Swal.fire({
                                        title: 'Error',
                                        text: (response.message),
                                        icon: 'error',
                                        // customClass: { icon: 'no-border' },
                                        timer: 1500

                                    });
                                } else {
                                    // Refresh datatable
                                    $('#datatable').DataTable().ajax.reload();

                                    // Tampilkan pesan sukses
                                    Swal.fire({
                                        title: 'Sukses',
                                        text: 'Data berhasil disimpan.',
                                        icon: 'success',
                                        timer:1500
                                    });
                                    $('#nama_risk').val(''); // Clear the value
                                    $('#kode_risk').val(''); // Clear the value
                                    $('#level_risk').val(''); // Clear the value
                                    $('#isaktif_risk').val(''); // Clear the value
                                }
                            }
                        });
                    }
                });

            });
        });
        $('body').on('click', '.conva-edit', function (e) {
            e.preventDefault();
            var id_risk = $(this).data('id');
            var selectedValue = $('#id_risk').val();
            $('#risk_id').val(id_risk);
            $(document).data('id_risk', id_risk); // Store 'id_risk' in document level data
            $.ajax({
                url: "{{ route('risk.edit') }}/" + id_risk,
                type: 'GET',
                success: function (response) {
                    $('#offcanvasExampleEdit').offcanvas('show');
                    $('#nama_risk_edit').val(response.result.nama_risk);
                    $('#kode_risk_edit').val(response.result.kode_risk);
                    $('#level_risk_edit').val(response.result.level_risk);
                    // $('option[name="audite"][value="'+ selectedValue +'"]').val(response.result.id_risk_auditee).prop('selected',true);
                    $('input[name="isaktif_risk"][value=""]').val(response.result.isaktif_risk);
                    if (isaktif_risk === 1) {
                    $('input[name="isaktif_risk"][value="1"]').prop('checked', true);
                } else {
                    $('input[name="isaktif_risk"][value="0"]').prop('checked', true);
                }
                }
            });
        });
        
        $(document).on('click', '.delete-data', function (e) {
    e.preventDefault();
    var id_risk = $(this).data('id');
    // var id_risk = $('#auditee_id').val();

    console.log(id_risk);
    Swal.fire({
        title: 'Apakah Anda yakin ingin hapus data?',
        text: 'Data yang telah disimpan tidak dapat diubah kembali.',
        icon: 'warning',
        showCancelButton: true,
        width: 500,
        confirmButtonColor: '#217AFF',
        cancelButtonColor: '#F1416C',
        customClass: { icon: 'no-border' },
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('risk.delete') }}/" + id_risk,
                success: function (response) {
                    if (response.errors) {
                        console.log(response.errors);
                        // Tampilkan pesan error
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            timer: 1500
                        });
                    } else {
                        // Refresh datatable
                        $('#datatable').DataTable().ajax.reload();

                        // Tampilkan pesan sukses
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 1500
                        });
                    }
                },
            });
        }
    });
});

        $(document).on('click', '.confir-edit', function (e) {
            e.preventDefault();
            var id_risk = $('#risk_id').val();

            // var id_risk = $(document).data('id_risk'); // Retrieve the stored 'id_risk'
            console.log(id_risk);
            Swal.fire({
                title: 'Apakah Anda yakin ingin menyimpan data?',
                text: 'Data yang telah disimpan tidak dapat diubah kembali.',
                icon: 'warning',
                showCancelButton: true,
                width: 500,
                confirmButtonColor: '#217AFF',
                cancelButtonColor: '#F1416C',
                customClass: { icon: 'no-border' },
                confirmButtonText: 'Ya, simpan',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var data = {
                        nama_risk: $('#nama_risk_edit').val(),
                        kode_risk: $('#kode_risk_edit').val(),
                        level_risk: $('#level_risk_edit').val(),
                        isaktif_risk: $('input[name="isaktif_risk"]:checked').val()
                    };

                    $.ajax({
                        type: "PUT",
                        url: "{{ route('risk.update') }}/" + id_risk,
                        data: data,
                        success: function (response) {
                            if (response.errors) {
                                console.log(response.errors);
                                // Tampilkan pesan error
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    // customClass: { icon: 'no-border' },
                                    timer: 1500
                                });
                            } else {
                                // Refresh datatable
                                $('#datatable').DataTable().ajax.reload();

                                // Tampilkan pesan sukses
                                Swal.fire({
                                    title: 'Sukses',
                                    text: 'Data berhasil disimpan.',
                                    icon: 'success',
                                    timer: 1500
                                });
                            }
                        }
                    });
                }
            });
    });
// });
        </script>
@endpush
