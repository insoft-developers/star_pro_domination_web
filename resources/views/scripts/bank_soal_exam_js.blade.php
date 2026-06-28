 <script>
     $(document).on('change', '#check_all', function() {
         $('.check_item').prop('checked', $(this).prop('checked'));

         toggleDeleteButton();
     });

     $(document).on('change', '.check_item', function() {

         $('#check_all').prop(
             'checked',
             $('.check_item:checked').length == $('.check_item').length
         );

         toggleDeleteButton();
     });

     function toggleDeleteButton() {

         if ($('.check_item:checked').length > 0) {
             $('#btn_delete_selected').prop('disabled', false);
         } else {
             $('#btn_delete_selected').prop('disabled', true);
         }

     }


     $('#btn_delete_selected').click(function() {

         var ids = [];

         $('.check_item:checked').each(function() {
             ids.push($(this).val());
         });

         console.log(ids);

     });


     $('#btn_delete_selected').click(function() {

         var ids = [];

         $('.check_item:checked').each(function() {
             ids.push($(this).val());
         });

         if (ids.length == 0) {
             alert('Pilih data terlebih dahulu');
             return;
         }

         if (confirm('Yakin ingin menghapus data yang dipilih?')) {

             $.ajax({
                 url: "{{ route('banksoal.selected.delete') }}",
                 type: "POST",
                 data: {
                     _token: "{{ csrf_token() }}",
                     ids: ids
                 },
                 success: function(res) {
                     $('#banksoal_exam_table').DataTable().ajax.reload();
                 }
             });

         }

     });
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
             [1, "desc"]
         ],
         columns: [{
                 data: 'id',
                 render: function(data, type, row) {
                     return `
            <input type="checkbox" class="check_item" value="${row.id}">
        `;
                 },
                 orderable: false,
                 searchable: false
             }, {
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
