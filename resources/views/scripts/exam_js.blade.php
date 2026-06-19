<script>
            var table = $('#exam_table').DataTable({
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
                ajax: "{{ route('examTable', $tryout->id) }}",
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'id_user',
                        name: 'id_user'
                    },
                    {
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'school_id',
                        name: 'school_id'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'id_kelas',
                        name: 'id_kelas'
                    },
                    {
                        data: 'score',
                        name: 'score'
                    },
                    {
                        data: 'target',
                        name: 'target'
                    },
                    {
                        data: 'resume',
                        name: 'resume'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'detail',
                        name: 'detail',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


            function listData(id) {
                $("#loadingProgress").show();
                $.ajax({
                    url: "{{ url('detail_exam') }}" + "/" + id,
                    type: "GET",
                    success: function(data) {
                        console.log(data);
                        $("#loadingProgress").hide();
                        $(".modal-title").text('Show Detail');
                        $("#modal-show-detail").modal("show");

                        $("#content-text").html(data);
                    }
                });
            }

            function deleteDataSession(id) {
                $("#id_hapus").val(id);
                $("#modal-hapus").modal("show");
            }

            function deleteDataConfirm() {
                var id = $("#id_hapus").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('tryout_session_delete') }}",
                    type: "POST",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function($data) {
                        table.ajax.reload(null, false);
                        $("#modal-hapus").modal("hide");
                    }
                });
            }
        </script>