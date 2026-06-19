<script>
            var table = $('#information_table').DataTable({
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
                ajax: "{{ route('informationTable') }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'information_title',
                        name: 'information_title'
                    },
                    {
                        data: 'information_image',
                        name: 'information_image'
                    },
                    {
                        data: 'information_content',
                        name: 'information_content'
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
                $("#information_image").attr("required", true);
                save_method = "add";
                $('input[name=_method]').val('POST');
                $(".modal-title").text("Add Information");
                $("#modal-add").modal("show");
            }


            function editData(id) {
                showLoading();
                $("#information_image").removeAttr("required");
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add form')[0].reset();
                $.ajax({
                    url: "{{ url('information') }}" + "/" + id + "/edit",
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        hideLoading();
                        $('#modal-add').modal("show");
                        $('.modal-title').text("Edit Information");
                        $('#id').val(data.id);
                        $("#information_title").val(data.information_title);
                        $("#information_content").val(data.information_content);
                        $("#is_active").val(data.is_active);

                    }
                })
            }



            $("#form-information").submit(function(e) {
                $("#loadingProgress").show();
                e.preventDefault();
                var id = $('#id').val();
                if (save_method == "add") url = "{{ url('information') }}";
                else url = "{{ url('information') . '/' }}" + id;
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
                    url: "{{ url('information') }}" + '/' + id,
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
                $("#information_title").val("");
                $("#information_image").val(null);
                $("#information_content").val("");
                $("#is_active").val("");
            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>