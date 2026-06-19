 <script>
            var table = $('#banksoal_exam_table').DataTable({
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
                ajax: "{{ route('bankSoalExamTable', $banksoal->id) }}",
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
                    url: "{{ url('banksoal_detail_exam') }}" + "/" + id,
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
        </script>