 <script>
     $('.my-colorpicker2').colorpicker();

     function copyData(id) {
         $("#dari").val(id);
         $("#modal-copy").modal("show");
         $(".modal-title").text("Copy Soal Bank Soal");
         $("#jenis").val("");
         $("#tujuan").html("");
     }


     $("#jenis").change(function() {
         var jenis = $(this).val();
         $.ajax({
             url: "{{ url('get_jenis_copy') }}" + "/" + jenis,
             type: "GET",
             dataType: "HTML",
             success: function(data) {
                 $("#tujuan").html(data);
             }
         })
     })


     $("#form-copy").submit(function(e) {
         e.preventDefault();
         $("#loadingProgress").show();
         $.ajax({
             url: "{{ url('copy_banksoal') }}",
             type: "POST",
             dataType: "JSON",
             data: $(this).serialize(),
             success: function(data) {
                 console.log(data);
                 $("#loadingProgress").hide();
                 $("#modal-copy").modal("hide");
                 table.ajax.reload(null, false);


             }
         })
     })


     function detailSoal(id) {
         window.location = "{{ url('bank_soal_detail') }}" + "/" + id;
     }

     $("#id_kelas").select2();



     var table = $('#tka_table').DataTable({
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
         ajax: "{{ route('tka.table') }}",
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
                 data: 'id_kelas',
                 name: 'id_kelas'
             },
             {
                 data: 'is_active',
                 name: 'is_active'
             },
             {
                 data: 'is_repeated',
                 name: 'is_repeated'
             },
             {
                 data: 'is_skipped',
                 name: 'is_skipped'
             },

             {
                 data: 'time_limit',
                 name: 'time_limit'
             },
             {
                 data: 'target_score',
                 name: 'target_score'
             },
             {
                 data: 'jumlah_soal',
                 name: 'jumlah_soal'
             },
             {
                 data: 'warna',
                 name: 'warna'
             },
             {
                 data: 'warna_jawaban',
                 name: 'warna_jawaban'
             },

         ]
     });


     function addData() {
         resetForm();
         save_method = "add";
         $('input[name=_method]').val('POST');
         $(".modal-title").text("Add Tka Soal");
         $("#modal-add").modal("show");
     }


     function editData(id) {
         showLoading();
         save_method = "edit";
         $('input[name=_method]').val('PATCH');
         $('#modal-add form')[0].reset();
         $.ajax({
             url: "{{ url('tka') }}" + "/" + id + "/edit",
             type: "GET",
             dataType: "JSON",
             success: function(data) {
                 hideLoading();
                 $('#modal-add').modal("show");
                 $('.modal-title').text("Edit TKA Soal");
                 $('#id').val(data.id);
                 $("#judul").val(data.judul);
                 $("#target_score").val(data.target_score);
                 $("#time_limit").val(data.time_limit);
                 $("#is_active").val(data.is_active);
                 $("#is_repeated").val(data.is_repeated);
                 $("#is_skipped").val(data.is_skipped);
                 $("#warna_soal").val(data.warna_soal).trigger('change');
                 $("#warna_tulisan").val(data.warna_tulisan).trigger('change');
                 $("#warna_jawaban").val(data.warna_jawaban).trigger('change');
                 $("#warna_tulisan_jawaban").val(data.warna_tulisan_jawaban).trigger('change');
                 let kelas = data.tka_kelas.map(item => item.id_kelas.toString());

                 $('#id_kelas').val(kelas).trigger('change');



             },

         })
     }



     $("#form-simpan").submit(function(e) {
         $("#loadingProgress").show();
         e.preventDefault();
         var id = $('#id').val();
         if (save_method == "add") url = "{{ url('tka') }}";
         else url = "{{ url('tka') . '/' }}" + id;
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

                 } else {
                     alert(data.message);
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
             url: "{{ url('banksoal') }}" + '/' + id,
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


     function copyData(id) {
         $("#dari").val(id);
         $("#modal-copy").modal("show");
     }

     $("#form-copy").submit(function(e) {
         e.preventDefault();
         $.ajax({
             url: "{{ url('copy_quiz') }}",
             type: "POST",
             dataType: "JSON",
             data: $(this).serialize(),
             success: function(data) {
                 console.log(data);
                 table.ajax.reload(null, false);
                 $("#modal-copy").modal("hide");
             }
         })
     })


     function resetForm() {
         $('#form-simpan')[0].reset();
         $("#id_kelas").val(null).trigger('change');

     }

     function showLoading() {
         $("#loadingProgress").show();
     }


     function hideLoading() {
         $("#loadingProgress").hide();
     }
 </script>
