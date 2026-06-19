  <script>
            function jawabData(id) {
                window.location = "{{ url('answer_question') }}" + "/" + id;
            }


            function editData(id) {
                $("#loadingProgress").show();
                save_method = "edit";
                $('input[name=_method]').val('PATCH');

                $.ajax({
                    url: "{{ url('edit_status_question') }}" + "/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $("#loadingProgress").hide();
                        $("#id").val(data.id);
                        $("#status").val(data.status);
                        $(".modal-title").text("Edit Status");
                        $("#modal-add").modal("show");

                    }
                });
            }


            $("#form-simpan").submit(function(e) {
                e.preventDefault();
                $("#loadingProgress").show();
                var id = $("#id").val();
                $.ajax({
                    url: "{{ url('update_question_status') }}" + "/" + id,
                    type: "POST",
                    dataType: "JSON",
                    data: $(this).serialize(),
                    success: function(data) {
                        $('#modal-add').modal('hide');
                        table.ajax.reload(null, false);
                        $("#loadingProgress").hide();
                    }
                })
            })

            var table = $('#question_table').DataTable({
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
                ajax: "{{ route('questionTable') }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'id_user',
                        name: 'id_user'
                    },
                    {
                        data: 'id_kelas',
                        name: 'id_kelas'
                    },
                    {
                        data: 'soal',
                        name: 'soal'
                    },
                    {
                        data: 'jawaban',
                        name: 'jawaban'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
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


            var table2 = $('#question_answer_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('questionAnswerTable', $ids) }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'jawaban',
                        name: 'jawaban'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            function addJawaban() {
                resetForm();
                save_method = "add";
                $('input[name=_method]').val('POST');
                $(".modal-title").text("Add Jawaban");
                $("#modal-add-jawaban").modal("show");
            }


            $("#form-simpan-jawaban").submit(function(e) {
                $("#loadingProgress").show();
                e.preventDefault();
                var id = $('#id').val();
                if (save_method == "add") url = "{{ url('jawaban_add') }}";
                else url = "{{ url('jawaban_update') . '/' }}" + id;

                var form_data = new FormData($('#modal-add-jawaban form')[0]);
                $.ajax({
                    url: url,
                    type: "POST",
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success == true) {
                            $('#modal-add-jawaban').modal('hide');
                            table2.ajax.reload(null, false);
                            $("#loadingProgress").hide();

                        }
                    }

                });
            });


            function editJawaban(id) {
                $("#loadingProgress").show();
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add-jawaban form')[0].reset();
                $.ajax({
                    url: "{{ url('jawaban_edit') }}" + "/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $("#loadingProgress").hide();
                        $('#modal-add-jawaban').modal("show");
                        $('.modal-title').text("Edit Jawaban");
                        $('#id').val(data.id);
                        $("#id_soal").val(data.id_soal);
                        $("#id_guru").val(data.id_guru);
                        $("#jawaban").val(data.jawaban);


                    }
                })
            }


            function deleteJawaban(id) {
                $("#id_hapus").val(id);
                $("#modal-hapus").modal("show");
            }

            function deleteDataConfirm() {
                var id = $("#id_hapus").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('jawaban_delete') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function($data) {
                        table2.ajax.reload(null, false);
                        $("#modal-hapus").modal("hide");
                    }
                });
            }

            function deleteImage(id) {
                var hapus = confirm('Hapus Gambar Ini...?');
                if (hapus === true) {
                    confirmHapusImage(id);
                }
            }

            function confirmHapusImage(id) {
                $("#loadingProgress").show();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('delete_answer_image') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        $("#loadingProgress").show();
                        table2.ajax.reload(null, false);

                    }
                })
            }

            function resetForm() {

            }
        </script>