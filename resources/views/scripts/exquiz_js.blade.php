<script>
            function count_records() {
                var id = "{{ Request::segment(2) }}";
                var awal = $("#tanggal_awal").val();
                var akhir = $("#tanggal_akhir").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                if (awal == '' || akhir == '') {
                    alert('Tanggal awal atau tanggal akhir tidak boleh kosong... ');
                } else {
                    $("#loadingProgress").show();
                    $.ajax({
                        url: "{{ route('count.quiz.record') }}",
                        dataType: "JSON",
                        type: "POST",
                        data: {
                            "id": id,
                            "awal": awal,
                            "akhir": akhir,
                            "_token": csrf_token
                        },
                        success: function(data) {
                            $("#loadingProgress").hide();
                            console.log(data);
                            $("#start_record").val(0);
                            $("#last_record").val(data);
                        }
                    })
                }
            }

            function detailData(id) {
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('quiz_result') }}",
                    type: "POST",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        $(".modal-title").text('Detail Quiz Answer');
                        $("#content-text").html(data);
                        $("#modal-show-detail").modal("show");
                    }
                })


            }

            function sessData(id) {
                window.location = "{{ url('sess_quiz') }}" + "/" + id;
            }

            // initTable("0","0");

            function tampilkan_laporan_session() {

                var awal = $("#tanggal_awal").val();
                var akhir = $("#tanggal_akhir").val();

                if (awal == '') {
                    awal = 0;
                } else {
                    awal = $("#tanggal_awal").val();
                }

                if (akhir == '') {
                    akhir = 0;
                } else {
                    akhir = $("#tanggal_akhir").val();
                }

                var offset = $("#start_record").val();
                var limit = $("#last_record").val();
                if (offset == '' || limit == '') {
                    alert('first record atau last record tidak boleh kosong!!');
                } else {
                    $("#sessquiz_table").dataTable().fnDestroy();
                    initTable(awal, akhir, offset, limit);
                }




            }


            function initTable(awal, akhir, offset, limit) {

                var ids = "{{ $ids }}";
                var table = $('#sessquiz_table').DataTable({
                    dom: 'Blfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'All'],
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('sessquizTable') }}" + "/" + ids + "/" + awal + "/" + akhir + '/' + offset + '/' +
                        limit,
                    order: [
                        [0, "desc"]
                    ],
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'judul',
                            name: 'judul'
                        },
                        {
                            data: 'siswa',
                            name: 'siswa'
                        },
                        {
                            data: 'nis',
                            name: 'nis'
                        },
                        {
                            data: 'school_id',
                            name: 'school_id'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'id_kelas',
                            name: 'id_kelas'
                        },
                        {
                            data: 'target_score',
                            name: 'target_score'
                        },
                        {
                            data: 'score',
                            name: 'score'
                        },
                        {
                            data: 'time',
                            name: 'time'
                        },
                        {
                            data: 'resume',
                            name: 'resume'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            }



            function soalData(id) {
                window.location = "{{ url('quizes') }}" + "/" + id;
            }


            var table = $('#exquiz_table').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('exquizTable') }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'id_kelas',
                        name: 'id_kelas'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


            function addData() {
                resetForm();
                save_method = "add";
                $('input[name=_method]').val('POST');
                $(".modal-title").text("Add Judul Quiz");
                $("#modal-add").modal("show");
            }


            function editData(id) {
                showLoading();
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add form')[0].reset();
                $.ajax({
                    url: "{{ url('quizheader') }}" + "/" + id + "/edit",
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        hideLoading();
                        $('#modal-add').modal("show");
                        $('.modal-title').text("Edit Judul Quiz");
                        $('#id').val(data.id);
                        $("#id_kelas").val(data.id_kelas);
                        $("#judul").val(data.judul);
                    },

                })
            }



            $("#form-simpan").submit(function(e) {
                $("#loadingProgress").show();
                e.preventDefault();
                var id = $('#id').val();
                if (save_method == "add") url = "{{ url('quizheader') }}";
                else url = "{{ url('quizheader') . '/' }}" + id;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: new FormData($('#modal-add form')[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success == true) {
                            $('#modal-add').modal('hide');
                            table.ajax.reload(null, false);
                            $("#loadingProgress").hide();

                        } else {
                            alert("Terjadi Kesalahan Atau Kelas Sudah Ada..!");
                            $("#loadingProgress").hide();
                        }
                    }

                });
            });


            function deleteData(id) {
                $("#id_hapus").val(id);
                $("#modal-hapus").modal("show");
            }

            function deleteSession(id) {

                $("#id_session").val(id);
                $("#modal-hapus-session").modal("show");
            }

            function deleteDataConfirm() {
                var id = $("#id_hapus").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('quizheader') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function(data) {
                        table.ajax.reload(null, false);
                        $("#modal-hapus").modal("hide");
                    }
                });
            }

            function deleteSessionConfirm() {
                var id = $("#id_session").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('quiz_session_delete') }}",
                    type: "POST",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        table.ajax.reload(null, false);
                        $("#modal-hapus-session").modal("hide");
                    }
                });
            }


            function copyData(id) {
                $("#dari").val(id);
                $("#modal-copy").modal("show");
            }

            $("#form-copy").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ url('copy_quiz') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: $(this).serialize(),
                    success: function(data) {
                        console.log(data);
                        table.ajax.reload(null, false);
                        $("#modal-copy").modal("hide");
                    }
                })
            })


            function resetForm() {

                $("#id_kelas").val("");
                $("#judul").val("");

            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>