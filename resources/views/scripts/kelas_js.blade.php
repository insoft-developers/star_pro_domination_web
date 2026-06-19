<script>
        var table = $('#kelas_table').DataTable({
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
            ajax: "{{ route('kelasTable') }}",
            order: [
                [0, "desc"]
            ],
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_kelas',
                    name: 'nama_kelas'
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
            $(".modal-title").text("Add Kelas");
            $("#modal-add").modal("show");
        }


        function editData(id) {
            showLoading();
            save_method = "edit";
            $('input[name=_method]').val('PATCH');
            $('#modal-add form')[0].reset();
            $.ajax({
                url: "{{ url('kelas') }}" + "/" + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    hideLoading();
                    $('#modal-add').modal("show");
                    $('.modal-title').text("Edit Kelas");
                    $('#id').val(data.id);
                    $("#nama_kelas").val(data.nama_kelas);

                }
            })
        }



        $("#form-simpan").submit(function(e) {
            $("#loadingProgress").show();
            e.preventDefault();
            var id = $('#id').val();
            if (save_method == "add") url = "{{ url('kelas') }}";
            else url = "{{ url('kelas') . '/' }}" + id;
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
                url: "{{ url('kelas') }}" + '/' + id,
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
            $("#nama_kelas").val("");

        }

        function showLoading() {
            $("#loadingProgress").show();
        }


        function hideLoading() {
            $("#loadingProgress").hide();
        }
    </script>