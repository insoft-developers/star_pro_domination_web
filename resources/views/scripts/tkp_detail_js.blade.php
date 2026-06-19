<script>
            function generateNomor() {
                var idtkp = $("#id_tkp").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('generate_nomor_tkp') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'idtkp': idtkp,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        $("#no_soal").val(data);
                    }
                });
            }

            var table = $('#tkp_detail_table').DataTable({
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
                ajax: "{{ route('tkp.detail.table', $ids) }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'no_soal',
                        name: 'no_soal'
                    },
                    {
                        data: 'soal',
                        name: 'soal'
                    },
                    {
                        data: 'jawaban_a',
                        name: 'jawaban_a'
                    },
                    {
                        data: 'score',
                        name: 'score'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
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
                $(".modal-title").text("Add TKP Detail");
                generateNomor();
                $("#modal-add").modal("show");
            }


            function editData(id) {
                showLoading();
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add form')[0].reset();
                $.ajax({
                    url: "{{ url('detail_tkp_edit') }}" + "/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                        hideLoading();
                        $('#modal-add').modal("show");
                        $('.modal-title').text("Edit Detail TKP");
                        $('#id').val(data.id);
                        $("#id_tkp").val(data.id_tkp);
                        $("#no_soal").val(data.no_soal);
                        $("#soal").val(data.soal);
                        $("#jawaban_a").val(data.jawaban_a);
                        $("#jawaban_b").val(data.jawaban_b);
                        $("#jawaban_c").val(data.jawaban_c);
                        $("#jawaban_d").val(data.jawaban_d);
                        $("#jawaban_e").val(data.jawaban_e);
                        $("#is_active").val(data.is_active);
                        $("#score_a").val(data.score_a);
                        $("#score_b").val(data.score_b);
                        $("#score_c").val(data.score_c);
                        $("#score_d").val(data.score_d);
                        $("#score_e").val(data.score_e);

                    }
                })
            }


            $("#form-simpan").submit(function(e) {
                $("#loadingProgress").show();
                e.preventDefault();
                var id = $('#id').val();
                if (save_method == "add") url = "{{ url('detail_tkp_add') }}";
                else url = "{{ url('detail_tkp_update') . '/' }}" + id;

                var form_data = new FormData($('#modal-add form')[0]);
                $.ajax({
                    url: url,
                    type: "POST",
                    data: form_data,
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


            function deleteImage(id, ind) {
                var hapus = confirm('Hapus Gambar Ini...?');
                if (hapus === true) {
                    confirmHapusImage(id, ind);
                }
            }

            function confirmHapusImage(id, type) {
                showLoading();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('delete_tkp_image') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'id': id,
                        'type': type,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        hideLoading();
                        table.ajax.reload(null, false);

                    }
                })
            }


            function deleteData(id) {
                $("#id_hapus").val(id);
                $("#modal-hapus").modal("show");
            }

            function deleteDataConfirm() {
                var id = $("#id_hapus").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('detail_tkp_delete') }}",
                    type: "POST",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        table.ajax.reload(null, false);
                        $("#modal-hapus").modal("hide");
                    }
                });
            }

            function deleteDataAll() {
                $("#modal-hapus-semua").modal("show");
            }

            function deleteAllDataConfirm() {
                var id = $("#id_hapus_semua").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('detail_tkp_delete_all') }}",
                    type: "POST",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        table.ajax.reload(null, false);
                        $("#modal-hapus-semua").modal("hide");
                    }
                });
            }


            function resetForm() {
                $("#id").val("");
                $("#no_soal").val("");
                $("#gambar_soal").val(null);
                $("#soal").val("")
                $("#gambar_a").val(null);
                $("#jawaban_a").val("");
                $("#gambar_b").val(null);
                $("#jawaban_b").val("");
                $("#gambar_c").val(null);
                $("#jawaban_c").val("");
                $("#gambar_d").val(null);
                $("#jawaban_d").val("");
                $("#gambar_e").val(null);
                $("#jawaban_e").val("");
                $("#score_a").val("");
                $("#score_b").val("");
                $("#score_c").val("");
                $("#score_d").val("");
                $("#score_e").val("");
                $("#is_active").val("");
            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>