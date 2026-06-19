 <script>
            $("#id_kelas").select2();

            $("#id_mapel").change(function() {
                var idMapel = $(this).val();
                $.ajax({
                    url: "{{ url('get_kelas_by_mapel') }}" + "/" + idMapel,
                    type: "GET",
                    success: function(data) {
                        $("#id_kelas").html(data);
                    }
                })

            });

            var table = $('#category_table').DataTable({
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
                ajax: "{{ route('kategoriTable') }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'category_image',
                        name: 'category_image'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
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
                $("#category_image").attr("required", true);
                save_method = "add";
                $('input[name=_method]').val('POST');
                $(".modal-title").text("Add Category");
                $("#modal-add").modal("show");
            }


            function editData(id) {
                showLoading();
                $("#category_image").removeAttr("required");
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add form')[0].reset();
                $.ajax({
                    url: "{{ url('kategori') }}" + "/" + id + "/edit",
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        hideLoading();
                        $('#modal-add').modal("show");
                        $('.modal-title').text("Edit Category");
                        $('#id').val(data.data.id);
                        $("#category_name").val(data.data.category_name);
                        $("#id_mapel").val(data.data.id_mapel);
                        $("#is_active").val(data.data.is_active);
                        $("#urutan").val(data.data.urutan);
                        $("#id_kelas").html(data.kelas);
                        $.ajax({
                            url: "{{ url('kategori_kelas') }}" + "/" + id,
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
                if (save_method == "add") url = "{{ url('kategori') }}";
                else url = "{{ url('kategori') . '/' }}" + id;
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
                    url: "{{ url('kategori') }}" + '/' + id,
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
                $("#category_image").val(null);
                $("#category_name").val("");
                $("#id_kelas").html("");
                $("#id_mapel").val("");
                $("#is_active").val("");
                $("#urutan").val("");

            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>