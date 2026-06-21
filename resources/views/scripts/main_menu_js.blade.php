<script>
        var table = $('#icon_table').DataTable({
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
            ajax: "{{ route('iconTable') }}",
            order: [
                [0, "desc"]
            ],
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'icon_image',
                    name: 'icon_image'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });


        function editData(id) {
            showLoading();
            save_method = "edit";
            $('input[name=_method]').val('PATCH');
            $('#modal-add form')[0].reset();
            $.ajax({
                url: "{{ url('icon') }}" + "/" + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    hideLoading();
                    $('#modal-add').modal("show");
                    $('.modal-title').text("Edit Icon Menu");
                    $('#id').val(data.id);
                    $("#name").val(data.name);

                }
            })
        }



        $("#form-save").submit(function(e) {
            $("#loadingProgress").show();
            e.preventDefault();
            var id = $('#id').val();
            if (save_method == "add") url = "{{ url('icon') }}";
            else url = "{{ url('icon') . '/' }}" + id;
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

        function showLoading() {
            $("#loadingProgress").show();
        }


        function hideLoading() {
            $("#loadingProgress").hide();
        }
    </script>