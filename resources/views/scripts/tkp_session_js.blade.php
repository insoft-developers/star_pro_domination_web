 <script>
     



     var table = $('#tkp_session_table').DataTable({
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
         ajax: "{{ route('tkp.session.table') }}",
         order: [
             [0, "desc"]
         ],
         columns: [{
                 data: 'id',
                 name: 'id'
             },
             {
                 data: 'action',
                 name: 'action',
                 orderable: false,
                 searchable: false
             },
             {
                 data: 'judul',
                 name: 'judul'
             },

             {
                 data: 'kelas',
                 name: 'kelas'
             },
             {
                 data: 'active',
                 name: 'active'
             },
             {
                 data: 'target_score',
                 name: 'target_score'
             },
             {
                 data: 'frequency',
                 name: 'frequency'
             },

             {
                 data: 'date',
                 name: 'date'
             },
        
         ]
     });


     
 </script>
