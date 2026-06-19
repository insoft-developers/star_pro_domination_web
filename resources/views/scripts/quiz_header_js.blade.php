<script>
            $("#id_kelas").select2();
            $(".my-colorpicker2").colorpicker();

            function soalData(id) {
                window.location = "{{ url('quizes') }}" + "/" + id;
            }


            var table = $('#quiz_header_table').DataTable({
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
                ajax: "{{ route('quizHeaderTable') }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'id_kelas',
                        name: 'id_kelas'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'waktu_kuis',
                        name: 'waktu_kuis'
                    },
                    {
                        data: 'target_score',
                        name: 'target_score'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
                    },
                    {
                        data: 'urutan',
                        name: 'urutan'
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
                        $('#id').val(data.data.id);
                        $("#id_kelas").val(data.kelas).trigger('change');
                        $("#judul").val(data.data.judul);
                        $("#waktu_kuis").val(data.data.waktu_kuis);
                        $("#target_score").val(data.data.target_score);
                        $("#urutan").val(data.data.urutan);
                        $("#is_active").val(data.data.is_active);
                        $("#short_name").val(data.data.short_name);
                        $("#warna_soal").val(data.data.warna_soal).trigger('change');
                        $("#warna_tulisan_soal").val(data.data.warna_tulisan_soal).trigger('change');
                        $("#warna_jawaban").val(data.data.warna_jawaban).trigger('change');
                        $("#warna_tulisan_jawaban").val(data.data.warna_tulisan_jawaban).trigger('change');
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
                $("#urutan").val("");
                $("#waktu_kuis").val("");
                $("#target_score").val("");
                $("#is_active").val("");
                $("#short_name").val("");
                $("#warna_soal").val("#FFFFFF").trigger("change");
                $("#warna_tulisan_soal").val("#000000").trigger("change");
                $("#warna_jawaban").val("#FFFFFF").trigger("change");
                $("#warna_tulisan_jawaban").val("#000000").trigger("change");

            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>