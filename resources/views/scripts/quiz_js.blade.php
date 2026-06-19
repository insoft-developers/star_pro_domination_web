 <script>
            CKEDITOR.replace('soal_kuis');
            CKEDITOR.replace('soal_bawah');
            CKEDITOR.replace('jawaban_a');
            CKEDITOR.replace('jawaban_b');
            CKEDITOR.replace('jawaban_c');
            CKEDITOR.replace('jawaban_d');
            CKEDITOR.replace('jawaban_e');



            function showEquation(element) {
                $("#" + element).show();
                $("#btn-show-" + element).hide();
            }

            function hideEquation(element) {
                $("#" + element).hide();
                $("#btn-show-" + element).show();
            }


            function insertEquation(mathFieldId, editorId) {
                let mf = document.getElementById(mathFieldId);
                let latex = document.getElementById(mathFieldId).value;

                CKEDITOR.instances[editorId].insertHtml(
                    '<span class="math-tex">\\(' + latex + '\\)</span>'
                );
                mf.value = "";
            }


            function clearEquation(mathFieldId) {
                let mf = document.getElementById(mathFieldId);
                mf.value = "";
            }


            var table = $('#quiz_table').DataTable({
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
                ajax: "{{ route('quizTable', $idquiz) }}",
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
                        data: 'no_kuis',
                        name: 'no_kuis'
                    },
                    {
                        data: 'soal_kuis',
                        name: 'soal_kuis'
                    },
                    {
                        data: 'jawaban_a',
                        name: 'jawaban_a'
                    },
                    {
                        data: 'kunci_jawaban',
                        name: 'kunci_jawaban'
                    },

                    {
                        data: 'score',
                        name: 'score'
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
                $(".modal-title").text("Add Soal Quiz");
                $("#modal-add").modal("show");
                generateNomor();
            }

            function generateNomor() {
                var idquiz = $("#id_quiz").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('generate_nomor_kuis') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'idquiz': idquiz,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        console.log("no kuis", data);
                        $("#no_kuis").val(data);
                    }
                });
            }


            function editData(id) {
                showLoading();
                save_method = "edit";
                $('input[name=_method]').val('PATCH');
                $('#modal-add form')[0].reset();
                $.ajax({
                    url: "{{ url('quiz') }}" + "/" + id + "/edit",
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        hideLoading();
                        $('#modal-add').modal("show");
                        $('.modal-title').text("Edit Soal Quiz");
                        $('#id').val(data.id);
                        $("#no_kuis").val(data.no_kuis);
                        $("#id_kelas").val(data.id_kelas);
                        // $("#soal_kuis").val(data.soal_kuis);
                        // $("#jawaban_a").val(data.jawaban_a);
                        // $("#jawaban_b").val(data.jawaban_b);
                        // $("#jawaban_c").val(data.jawaban_c);
                        // $("#jawaban_d").val(data.jawaban_d);
                        // $("#jawaban_e").val(data.jawaban_e);

                        CKEDITOR.instances.soal_kuis.setData(data.soal_kuis);
                        CKEDITOR.instances.soal_bawah.setData(data.soal_bawah);
                        CKEDITOR.instances.jawaban_a.setData(data.jawaban_a);
                        CKEDITOR.instances.jawaban_b.setData(data.jawaban_b);
                        CKEDITOR.instances.jawaban_c.setData(data.jawaban_c);
                        CKEDITOR.instances.jawaban_d.setData(data.jawaban_d);
                        CKEDITOR.instances.jawaban_e.setData(data.jawaban_e);

                        $("#kunci_jawaban").val(data.kunci_jawaban);
                        $("#score").val(data.score);


                    }
                })
            }



            $("#form-simpan").submit(function(e) {
                $("#loadingProgress").show();
                e.preventDefault();
                var id = $('#id').val();
                if (save_method == "add") url = "{{ url('quiz') }}";
                else url = "{{ url('quiz') . '/' }}" + id;

                var form_data = new FormData($('#modal-add form')[0]);

                var soalKuis = CKEDITOR.instances.soal_kuis.getData();
                var soalBawah = CKEDITOR.instances.soal_bawah.getData();
                var jawabanA = CKEDITOR.instances.jawaban_a.getData();
                var jawabanB = CKEDITOR.instances.jawaban_b.getData();
                var jawabanC = CKEDITOR.instances.jawaban_c.getData();
                var jawabanD = CKEDITOR.instances.jawaban_d.getData();
                var jawabanE = CKEDITOR.instances.jawaban_e.getData();


                form_data.append('soal_kuis', soalKuis);
                form_data.append('soal_bawah', soalBawah);
                form_data.append('jawaban_a', jawabanA);
                form_data.append('jawaban_b', jawabanB);
                form_data.append('jawaban_c', jawabanC);
                form_data.append('jawaban_d', jawabanD);
                form_data.append('jawaban_e', jawabanE);


                $.ajax({
                    url: url,
                    type: "POST",
                    data: form_data,
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
                    url: "{{ url('quiz') }}" + '/' + id,
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


            function deleteImage(id, ind) {
                var hapus = confirm('Hapus Gambar Ini...?');
                if (hapus === true) {
                    confirmHapusImage(id, ind);
                }
            }

            function confirmHapusImage(id, type) {
                showLoading();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('delete_quiz_image') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'id': id,
                        'type': type,
                        '_token': csrf_token
                    },
                    success: function(data) {
                        hideLoading();
                        table.ajax.reload(null, false);

                    }
                })
            }





            function resetForm() {
                $("#no_kuis").val("");
                CKEDITOR.instances.soal_kuis.setData('');
                CKEDITOR.instances.soal_bawah.setData('');
                CKEDITOR.instances.jawaban_a.setData('');
                CKEDITOR.instances.jawaban_b.setData('');
                CKEDITOR.instances.jawaban_c.setData('');
                CKEDITOR.instances.jawaban_d.setData('');
                CKEDITOR.instances.jawaban_e.setData('');
                $("#kunci_jawaban").val("");
                $("#score").val("");
                $("#gambar_soal").val(null);
                $("#gambar_a").val(null);
                $("#gambar_b").val(null);
                $("#gambar_c").val(null);
                $("#gambar_d").val(null);
                $("#gambar_e").val(null);


            }

            function showLoading() {
                $("#loadingProgress").show();
            }


            function hideLoading() {
                $("#loadingProgress").hide();
            }
        </script>