<script>
            $("#id_kelas").select2();
            var table = $('#ref_table').DataTable({
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
                ajax: "{{ route('refTable') }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'ref_image',
                        name: 'ref_image'
                    },
                    {
                        data: 'ref_url',
                        name: 'ref_url'
                    },
                    {
                        data: 'ref_title',
                        name: 'ref_title'
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
                $("#ref_image").attr("required", true);
                save_method = "add";
                $('input[name=_method]').val('POST');
                $(".modal-title").text("Add Reference");
                $("#modal-add").modal("show");
            }


            function editData(id) {
                showLoading();
                $("#ref_image").removeAttr("required");
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add form')[0].reset();
                $.ajax({
                    url: "{{ url('ref') }}" + "/" + id + "/edit",
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        hideLoading();
                        $('#modal-add').modal("show");
                        $('.modal-title').text("Edit Reference");
                        $('#id').val(data.data.id);
                        $("#ref_title").val(data.data.ref_title);
                        $("#ref_url").val(data.data.ref_url);
                        $("#id_kelas").val(data.kelas).trigger('change');
                        $("#is_active").val(data.data.is_active);

                    }
                })
            }



            $("#form-add").submit(function(e) {
                $("#loadingProgress").show();
                e.preventDefault();
                var id = $('#id').val();
                if (save_method == "add") url = "{{ url('ref') }}";
                else url = "{{ url('ref') . '/' }}" + id;
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
                    url: "{{ url('ref') }}" + '/' + id,
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
                $("#ref_image").val(null);
                $("#id_kelas").val("").trigger('change');
                $("#ref_title").val("");
                $("#ref_url").val("");
                $("#is_active").val("");
            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>