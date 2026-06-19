 <script>
            $('.my-colorpicker2').colorpicker();

            function copyData(id) {
                $("#dari").val(id);
                $("#modal-copy").modal("show");
                $(".modal-title").text("Copy Soal Bank Soal");
                $("#jenis").val("");
                $("#tujuan").html("");
            }


            $("#jenis").change(function() {
                var jenis = $(this).val();
                $.ajax({
                    url: "{{ url('get_jenis_copy') }}" + "/" + jenis,
                    type: "GET",
                    dataType: "HTML",
                    success: function(data) {
                        $("#tujuan").html(data);
                    }
                })
            })


            $("#form-copy").submit(function(e) {
                e.preventDefault();
                $("#loadingProgress").show();
                $.ajax({
                    url: "{{ url('copy_banksoal') }}",
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


            function detailSoal(id) {
                window.location = "{{ url('bank_soal_detail') }}" + "/" + id;
            }

            $("#id_kelas").select2();

            $("#id_kategori").change(function() {
                var id = $(this).val();
                $.ajax({
                    url: "{{ url('category_bimbel') }}" + "/" + id,
                    type: "GET",
                    success: function(data) {
                        $("#id_kelas").html(data.kelas);
                    }
                });
            });

            var table = $('#banksoal_table').DataTable({
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
                ajax: "{{ route('bankSoalTable') }}",
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
                        data: 'id_kategori',
                        name: 'id_kategori'
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
                $(".modal-title").text("Add Bank Soal");
                $("#modal-add").modal("show");
            }


            function editData(id) {
                showLoading();
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add form')[0].reset();
                $.ajax({
                    url: "{{ url('banksoal') }}" + "/" + id + "/edit",
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        hideLoading();
                        $('#modal-add').modal("show");
                        $('.modal-title').text("Edit Bank Soal");
                        $('#id').val(data.data.id);
                        $("#judul").val(data.data.judul);
                        $("#id_kategori").val(data.data.id_kategori);
                        $("#target_score").val(data.data.target_score);
                        $("#is_active").val(data.data.is_active);
                        $("#is_repeated").val(data.data.is_repeated);
                        $("#is_skipped").val(data.data.is_skipped);
                        $("#warna_soal").val(data.data.warna_soal).trigger('change');
                        $("#warna_tulisan").val(data.data.warna_tulisan).trigger('change');
                        $("#short_name").val(data.data.short_name);
                        $("#warna_jawaban").val(data.data.warna_jawaban).trigger('change');
                        $("#warna_tulisan_jawaban").val(data.data.warna_tulisan_jawaban).trigger('change');

                        $("#id_kelas").html(data.kelas);

                        $.ajax({
                            url: "{{ url('kelas_by_bank_soal') }}" + "/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data) {
                                $("#id_kelas").val(data).trigger('change');
                            }
                        })

                    },

                })
            }



            $("#form-simpan").submit(function(e) {
                $("#loadingProgress").show();
                e.preventDefault();
                var id = $('#id').val();
                if (save_method == "add") url = "{{ url('banksoal') }}";
                else url = "{{ url('banksoal') . '/' }}" + id;
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
                    url: "{{ url('banksoal') }}" + '/' + id,
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
                $("#judul").val("");
                $("#id_kategori").val("");
                $("#id_kelas").html("");
                $("#target_score").val("");
                $("#is_active").val("");
                $("#is_repeated").val("");
                $("#is_skipped").val("");
                $("#warna_soal").val("#FFFFFF").trigger('change');
                $("#warna_tulisan").val("#000000").trigger('change');

            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>