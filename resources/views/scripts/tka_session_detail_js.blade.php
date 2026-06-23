 <script>
     
     var filterId = window.location.pathname.split('/').pop();


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


     
 </script>
