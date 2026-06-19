 <script>
            

            $("#id_kelas").select2();

            $("#id_kategori").change(function() {
                var id = $(this).val();
                $.ajax({
                    url: "{{ url('category_bimbel') }}" + "/" + id,
                    type: "GET",
                    success: function(data) {
                        console.log(data);
                        $("#id_mapel").html(data.mapel);
                        $("#id_kelas").html(data.kelas);
                    }
                });
            });


            var table = $('#materi_table').DataTable({
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
                ajax: "{{ route('materiTable') }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'link_file',
                        name: 'link_file'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas'
                    },
                    {
                        data: 'mapel_name',
                        name: 'mapel_name'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
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
                $(".modal-title").text("Add Materi Pelajaran");
                $("#modal-add").modal("show");
            }


            function editData(id) {
                showLoading();
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add form')[0].reset();
                $.ajax({
                    url: "{{ url('materi') }}" + "/" + id + "/edit",
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                        hideLoading();
                        $('#modal-add').modal("show");
                        $('.modal-title').text("Edit Materi Pelajaran");
                        $('#id').val(data.data.id);
                        $("#judul").val(data.data.judul);
                        $("#link_file").val(data.data.link_file);
                        $("#is_active").val(data.data.is_active);
                        $("#id_kategori").val(data.data.id_kategori);
                        $("#id_mapel").html('<option value="' + data.mapel.id + '">' + data.mapel.mapel_name +
                            '</option>');
                        $("#id_kelas").html(data.kelas);

                        $.ajax({
                            url: "{{ url('kelas_materi_select') }}" + "/" + id,
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
                if (save_method == "add") url = "{{ url('materi') }}";
                else url = "{{ url('materi') . '/' }}" + id;
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
                    url: "{{ url('materi') }}" + '/' + id,
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
                $("#link_file").val("");
                $("#id_kelas").val("");
                $("#id_mapel").val("");
                $("#id_kategori").val("");
                $("#is_active").val("");

            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>