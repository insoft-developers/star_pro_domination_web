 <script>
            $("#id_kelas").select2();
            $('.my-colorpicker2').colorpicker();

            function listData(id) {
                window.location = "{{ url('tkp_detail') }}" + "/" + id;
            }

            function copyData(id) {
                $("#dari").val(id);
                $("#modal-copy").modal("show");
                $(".modal-title").text("Copy Soal TKP");

            }




            $("#form-copy").submit(function(e) {
                e.preventDefault();
                $("#loadingProgress").show();
                $.ajax({
                    url: "{{ url('copy_tkp') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: $(this).serialize(),
                    success: function(data) {
                        console.log(data);
                        $("#loadingProgress").hide();
                        $("#modal-copy").modal("hide");
                        table.ajax.reload(null, false);


                    }
                })
            })


            var table = $('#tkp_table').DataTable({
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
                ajax: "{{ route('tkp.table') }}",
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
                        data: 'is_active',
                        name: 'is_active'
                    },
                    {
                        data: 'is_repeated',
                        name: 'is_repeated'
                    },
                    {
                        data: 'is_skipped',
                        name: 'is_skipped'
                    },
                    {
                        data: 'time_limit',
                        name: 'time_limit'
                    },
                    {
                        data: 'target_score',
                        name: 'target_score'
                    },
                    {
                        data: 'jumlah_soal',
                        name: 'jumlah_soal'
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
                $(".modal-title").text("Add TKP");
                $("#modal-add").modal("show");
            }


            function editData(id) {
                showLoading();
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add form')[0].reset();
                $.ajax({
                    url: "{{ url('tkp') }}" + "/" + id + "/edit",
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                        hideLoading();
                        $('#modal-add').modal("show");
                        $('.modal-title').text("Edit TKP");
                        $('#id').val(data.id);
                        $("#judul").val(data.judul);
                        $("#short_name").val(data.short_name);
                        $("#is_repeated").val(data.is_repeated);
                        $("#is_skipped").val(data.is_skipped);
                        $("#target_score").val(data.target_score);
                        $("#time_limit").val(data.time_limit);
                        $("#is_active").val(data.is_active);

                        $("#warna_soal").val(data.warna_soal).trigger('change');
                        $("#warna_tulisan").val(data.warna_tulisan).trigger('change');
                        $("#warna_jawaban").val(data.warna_jawaban).trigger('change');
                        $("#warna_tulisan_jawaban").val(data.warna_tulisan_jawaban).trigger('change');

                        $.ajax({
                            url: "{{ url('kelas_by_tkp') }}" + "/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data) {
                                $("#id_kelas").val(data).trigger('change');
                            }
                        })

                    }
                })
            }



            $("#form-simpan").submit(function(e) {
                $("#loadingProgress").show();
                e.preventDefault();
                var id = $('#id').val();
                if (save_method == "add") url = "{{ url('tkp') }}";
                else url = "{{ url('tkp') . '/' }}" + id;
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

                        }
                    }

                });
            });


            function deleteData(id) {
                $("#id_hapus").val(id);
                $("#modal-hapus").modal("show");
            }

            function deleteDataConfirm() {
                var id = $("#id_hapus").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('tkp') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function($data) {
                        table.ajax.reload(null, false);
                        $("#modal-hapus").modal("hide");
                    }
                });
            }




            function resetForm() {
                $("#judul").val("");
                $("#id_kelas").val("");
                $("#target_score").val("");
                $("#time_limit").val("");
                $("#is_repeated").val("");
                $("#is_skipped").val("");
                $("#is_active").val("");
                $("#warna_soal").val("#ffffff").trigger('change');
                $("#warna_tulisan").val("#000000").trigger('change');
                $("#warna_jawaban").val("#ffffff").trigger('change');
                $("#warna_tulisan_jawaban").val("#000000").trigger('change');

            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>