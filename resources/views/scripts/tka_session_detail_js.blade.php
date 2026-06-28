 <script>
     var filterId = window.location.pathname.split('/').pop();

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
                 url: "{{ route('tka.selected.delete') }}",
                 type: "POST",
                 data: {
                     _token: "{{ csrf_token() }}",
                     ids: ids
                 },
                 success: function(res) {
                     $('#tka_session_detail_table').DataTable().ajax.reload();
                 }
             });

         }

     });


     var table = $('#tka_session_detail_table').DataTable({
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
         //  ajax: "{{ route('tka.session.detail.table') }}",
         ajax: {
             url: "{{ route('tka.session.detail.table') }}",
             data: function(d) {
                 d.filter_id = filterId;
             },
         },
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
             },
             {
                 data: 'id',
                 name: 'id'
             },

             {
                 data: 'judul',
                 name: 'judul'
             },

             {
                 data: 'siswa',
                 name: 'siswa'
             },
             {
                 data: 'nis',
                 name: 'nis'
             },
             {
                 data: 'sekolah',
                 name: 'sekolah'
             },
             {
                 data: 'telp',
                 name: 'telp'
             },

             {
                 data: 'kelas',
                 name: 'kelas'
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
                 data: 'date',
                 name: 'date'
             },
             {
                 data: 'detail',
                 name: 'detail',
                 orderable: false,
                 searchable: false
             },

         ]
     });

     function listData(id) {

         $.ajax({
             url: "{{ url('tka_show_session_detail?id=') }}" + id,
             type: "GET",
             success: function(data) {
                 console.log(data);

                 $(".modal-title").text('Show Session Detail');
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
             url: "{{ url('tka_session_delete') }}" + '/' + id,
             type: "POST",
             data: {
                 '_method': 'DELETE',
                 '_token': csrf_token
             },
             success: function(data) {
                 table.ajax.reload(null, false);
                 $("#modal-hapus").modal("hide");
             }
         });
     }
 </script>
