 <script>
            var table = $('#lapor_table').DataTable({
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
                ajax: "{{ route('laporTable') }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'kelas',
                        name: 'kelas'
                    },
                    {
                        data: 'soal',
                        name: 'soal'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'status',
                        name: 'status'
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

            function finishData(id) {
                $("#id_finish").val(id);
                $("#modal-finish").modal("show");
            }

            function finishDataConfirm() {
                $("#loadingProgress").show();
                var id = $("#id_finish").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('lapor_finish') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        $("#loadingProgress").hide();
                        table.ajax.reload(null, false);
                        $("#modal-finish").modal("hide");
                    }
                })
            }



            function outstandData(id) {
                $("#id_outstanding").val(id);
                $("#modal-outstanding").modal("show");
            }

            function outstandDataConfirm() {
                $("#loadingProgress").show();
                var id = $("#id_outstanding").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('lapor_outstanding') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        $("#loadingProgress").hide();
                        table.ajax.reload(null, false);
                        $("#modal-outstanding").modal("hide");
                    }
                })
            }
        </script>