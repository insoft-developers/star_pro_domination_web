<script>
            var table = $('#slider_table').DataTable({
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
                ajax: "{{ route('sliderTable') }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'slider_image',
                        name: 'slider_image'
                    },
                    {
                        data: 'slider_description',
                        name: 'slider_description'
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
                $("#slider_image").attr("required", true);
                save_method = "add";
                $('input[name=_method]').val('POST');
                $(".modal-title").text("Add Slider");
                $("#modal-add-slider").modal("show");
            }


            function editData(id) {
                showLoading();
                $("#slider_image").removeAttr("required");
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add-slider form')[0].reset();
                $.ajax({
                    url: "{{ url('slider') }}" + "/" + id + "/edit",
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        hideLoading();
                        $('#modal-add-slider').modal("show");
                        $('.modal-title').text("Edit Slider");
                        $('#id').val(data.id);
                        $("#slider_description").val(data.slider_description);
                        $("#is_active").val(data.is_active);

                    }
                })
            }



            $("#form-slider").submit(function(e) {
                $("#loadingProgress").show();
                e.preventDefault();
                var id = $('#id').val();
                if (save_method == "add") url = "{{ url('slider') }}";
                else url = "{{ url('slider') . '/' }}" + id;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: new FormData($('#modal-add-slider form')[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success == true) {
                            $('#modal-add-slider').modal('hide');
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
                    url: "{{ url('slider') }}" + '/' + id,
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
                $("#slider_image").val(null);
                $("#slider_description").val("");
                $("#is_active").val("");
            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>