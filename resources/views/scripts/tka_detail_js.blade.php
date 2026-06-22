<script>
    var filterId = window.location.pathname.split('/').pop();



    function lihatData(id) {

        $.ajax({
            url: "{{ url('lihat_soal_tka?id=') }}" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var html = '';
                html += `<h4>Soal No ${data.no_soal}</h4>`;
                var gambar = '';
                if (data.gambar_soal) {
                    var linkGambar = '';
                    linkGambar = "{{ asset('/images/question') }}" + '/' + data.gambar_soal;

                    gambar += `<img style="width:600px;" class="img-responsive" src="${linkGambar}">`;
                }

                var soalBawah = '';
                if (data.soal_bawah) {
                    soalBawah += data.soal_bawah;
                }
                html += `<h4 class="soal-tka">${data.soal}<br>${gambar}<br>${soalBawah}</h4>`;

                html += '<div class="jawaban-tka">';

                let gambarA = '';
                let gambarB = '';
                let gambarC = '';
                let gambarD = '';
                let gambarE = '';

                if (data.gambar_a) {
                    linkGambarA = "{{ asset('/images/question') }}" + '/' + data.gambar_a;
                    gambarA += `<img style="width:300px;" class="img-responsive" src="${linkGambarA}"><br>`;
                }
                if (data.gambar_b) {
                    linkGambarB = "{{ asset('/images/question') }}" + '/' + data.gambar_b;
                    gambarB += `<img style="width:300px;" class="img-responsive" src="${linkGambarB}"><br>`;
                }
                if (data.gambar_c) {
                    linkGambarC = "{{ asset('/images/question') }}" + '/' + data.gambar_c;
                    gambarC += `<img style="width:300px;" class="img-responsive" src="${linkGambarC}"><br>`;
                }
                if (data.gambar_d) {
                    linkGambarD = "{{ asset('/images/question') }}" + '/' + data.gambar_d;
                    gambarD += `<img style="width:300px;" class="img-responsive" src="${linkGambarD}"><br>`;
                }
                if (data.gambar_e) {
                    linkGambarE = "{{ asset('/images/question') }}" + '/' + data.gambar_e;
                    gambarE += `<img style="width:300px;" class="img-responsive" src="${linkGambarE}"><br>`;
                }

                if (data.question_model == 1) {
                    html +=
                    `<div class="jawaban-item"><strong>A.</strong>${gambarA}${data.jawaban_a}</div>`;
                    html +=
                    `<div class="jawaban-item"><strong>B.</strong>${gambarB}${data.jawaban_b}</div>`;
                    html +=
                    `<div class="jawaban-item"><strong>C.</strong>${gambarC}${data.jawaban_c}</div>`;
                    html +=
                    `<div class="jawaban-item"><strong>D.</strong>${gambarD}${data.jawaban_d}</div>`;
                    html +=
                    `<div class="jawaban-item"><strong>E.</strong>${gambarE}${data.jawaban_e}</div>`;

                } else if (data.question_model == 2) {
                    html +=
                        `<div class="jawaban-item"><strong></strong>${gambarA}<input type="checkbox"><span class="item-item">${data.jawaban_a}</span></div>`;
                    html +=
                        `<div class="jawaban-item"><strong></strong>${gambarB}<input type="checkbox"><span class="item-item">${data.jawaban_b}</span></div>`;
                    html +=
                        `<div class="jawaban-item"><strong></strong>${gambarC}<input type="checkbox"><span class="item-item">${data.jawaban_c}</span></div>`;
                    html +=
                        `<div class="jawaban-item"><strong></strong>${gambarD}<input type="checkbox"><span class="item-item">${data.jawaban_d}</span></div>`;
                    if (data.jawaban_e || data.gambar_e) {
                        html +=
                            `<div class="jawaban-item"><strong></strong>${gambarE}<input type="checkbox"><span class="item-item">${data.jawaban_e}</span></div>`;

                    }

                } else if (data.question_model == 3) {
                    var itemTable = '';
                    if (data.jawaban_a || data.gambar_a) {
                        itemTable += `<tr>
                                    <td>1</td>
                                    <td>${gambarA}${data.jawaban_a}</td>
                                    <td><center><input type="checkbox"></center></td>
                                    <td><center><input type="checkbox"></center></td>
                                </tr>`;
                    }
                    if (data.jawaban_b || data.gambar_b) {
                        itemTable += `<tr>
                                    <td>2</td>
                                    <td>${gambarB}${data.jawaban_b}</td>
                                    <td><center><input type="checkbox"></center></td>
                                    <td><center><input type="checkbox"></center></td>
                                </tr>`;
                    }

                    if (data.jawaban_c || data.gambar_c) {
                        itemTable += `<tr>
                                    <td>3</td>
                                    <td>${gambarC}${data.jawaban_c}</td>
                                    <td><center><input type="checkbox"></center></td>
                                    <td><center><input type="checkbox"></center></td>
                                </tr>`;
                    }

                    if (data.jawaban_d || data.gambar_d) {
                        itemTable += `<tr>
                                    <td>4</td>
                                    <td>${gambarD}${data.jawaban_d}</td>
                                    <td><center><input type="checkbox"></center></td>
                                    <td><center><input type="checkbox"></center></td>
                                </tr>`;
                    }

                    if (data.jawaban_e || data.gambar_e) {
                        itemTable += `<tr>
                                    <td>5</td>
                                    <td>${gambarE}${data.jawaban_e}</td>
                                    <td><center><input type="checkbox"></center></td>
                                    <td><center><input type="checkbox"></center></td>
                                </tr>`;
                    }



                    html += `<table class="table">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pernyataan</th>
                                        <th><center>Benar</center></th>
                                        <th><center>Salah</center></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        ${itemTable}
                                    </tbody>
                                </table>`;

                    if (data.jawaban_a || data.gambar_a) {


                    }

                }
                html += '</div>';


                $("#lihat-tka-container").html(html);
                if (window.MathJax) {
                    MathJax.typesetPromise([document.getElementById('lihat-tka-container')]);
                }
                $("#modal-lihat").modal('show');
                $(".modal-title").text('Lihat Soal');


            }
        });

    }


    function renderKunciJawaban(questionModel, kunciJawaban = null) {

        var html = '';
        if (questionModel == '1') {
            html += `<select class="form-control" id="kunci_jawaban" name="kunci_jawaban" required>
                    <option value=""> - Pilih - </option>
                    <option value="a"> A </option>
                    <option value="b"> B </option>
                    <option value="c"> C </option>
                    <option value="d"> D </option>
                    <option value="e"> E </option>
                </select>`;
            $("#label_kunci_jawaban").show();
            $("#jawaban_container").show();
        } else if (questionModel == '2') {
            html += `<select style="width:"100%;" id="kunci_jawaban" multiple name="kunci_jawaban[]" required>
                    <option value=""> - Pilih - </option>
                    <option value="a"> A </option>
                    <option value="b"> B </option>
                    <option value="c"> C </option>
                    <option value="d"> D </option>
                    <option value="e"> E </option>
                </select>`;

            setTimeout(function() {
                $('#kunci_jawaban').select2({
                    width: '100%',
                    placeholder: '- Pilih -',
                    allowClear: true
                });
            }, 100);
            $("#label_kunci_jawaban").show();
            $("#jawaban_container").show();
        } else if (questionModel == '3') {
            html += `<div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Pernyataan A</label>
                                <select class="form-control" id="kunci_jawaban_a" name="kunci_jawaban[]">
                                    <option value="">- Pilih -</option>
                                    <option value="a_1">Benar</option>
                                    <option value="a_0">Salah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Pernyataan B</label>
                                <select class="form-control" id="kunci_jawaban_b" name="kunci_jawaban[]">
                                    <option value="">- Pilih -</option>
                                    <option value="b_1">Benar</option>
                                    <option value="b_0">Salah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Pernyataan C</label>
                                <select class="form-control" id="kunci_jawaban_c" name="kunci_jawaban[]">
                                    <option value="">- Pilih -</option>
                                    <option value="c_1">Benar</option>
                                    <option value="c_0">Salah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Pernyataan D</label>
                                <select class="form-control" id="kunci_jawaban_d" name="kunci_jawaban[]">
                                    <option value="">- Pilih -</option>
                                    <option value="d_1">Benar</option>
                                    <option value="d_0">Salah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Pernyataan E</label>
                                <select class="form-control" id="kunci_jawaban_e" name="kunci_jawaban[]">
                                    <option value="">- Pilih -</option>
                                    <option value="e_1">Benar</option>
                                    <option value="e_0">Salah</option>
                                </select>
                            </div>
                        </div>
                    </div>`;

            $("#label_kunci_jawaban").show();
            $("#jawaban_container").show();
        } else if (questionModel == '4') {
            html +=
                `<textarea class="form-control" id="kunci_jawaban" name="kunci_jawaban" placeholder="Jika jawaban lebih dari satu berikan tanda pemisah | misal: Jakarta|Bandung|Medan"></textarea>`;
            $("#label_kunci_jawaban").show();
            $("#jawaban_container").hide();
        }


        $('#kunci_jawaban_container').html(html);

        if (kunciJawaban) {

            if (questionModel == '1') {
                $('#kunci_jawaban').val(kunciJawaban);
            }

            if (questionModel == '2') {
                console.log(kunciJawaban.split(','));
                $('#kunci_jawaban').val(kunciJawaban.split('|')).trigger('change');
            }

            if (questionModel == '3') {

                kunciJawaban.split('|').forEach(function(item) {

                    let huruf = item.split('_')[0];

                    $('#kunci_jawaban_' + huruf).val(item);

                });

            }

            if (questionModel == '4') {
                $('#kunci_jawaban').val(kunciJawaban);
            }
        }
    }


    $("#question_model").change(function() {
        var questionModel = $(this).val();
        renderKunciJawaban(questionModel);
    });


    function generateNomorSoal() {
        $.ajax({
            url: "{{ url('generate_nomor_soal_tka?filter_id=') }}" + filterId,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $("#no_soal").val(data);
            }
        })
    }




    var table = $('#list-table').DataTable({
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
        ajax: {
            url: "{{ route('tka.detail.table') }}",
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
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },

            {
                data: 'no_soal',
                name: 'no_soal'
            },


            {
                data: 'soal',
                name: 'soal'
            },
            {
                data: 'gambar_soal',
                name: 'gambar_soal'
            },
            {
                data: 'soal_bawah',
                name: 'soal_bawah'
            },
            {
                data: 'jawaban_a',
                name: 'jawaban_a'
            },
            {
                data: 'jawaban_b',
                name: 'jawaban_b'
            },
            {
                data: 'jawaban_c',
                name: 'jawaban_c'
            },
            {
                data: 'jawaban_d',
                name: 'jawaban_d'
            },
            {
                data: 'jawaban_e',
                name: 'jawaban_e'
            },
            {
                data: 'model',
                name: 'model'
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
                data: 'is_active',
                name: 'is_active'
            },
        ]
    });


    CKEDITOR.replace('soal');
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





    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add TKA Data Detail");
        $("#modal-add").modal("show");
        generateNomorSoal();
    }


    function editData(id) {

        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
            url: "{{ url('tka_detail') }}" + "/" + id + '/edit',
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data);

                $('#modal-add').modal("show");
                $('.modal-title').text("Edit TKA Detail");
                $('#id').val(data.id);
                $("#tka_id").val(data.tka_id);
                $("#no_soal").val(data.no_soal);


                CKEDITOR.instances.soal.setData(data.soal);
                CKEDITOR.instances.soal_bawah.setData(data.soal_bawah);
                CKEDITOR.instances.jawaban_a.setData(data.jawaban_a);
                CKEDITOR.instances.jawaban_b.setData(data.jawaban_b);
                CKEDITOR.instances.jawaban_c.setData(data.jawaban_c);
                CKEDITOR.instances.jawaban_d.setData(data.jawaban_d);
                CKEDITOR.instances.jawaban_e.setData(data.jawaban_e);

                $("#score").val(data.score);
                $("#is_active").val(data.is_active);
                $("#question_model").val(data.question_model);

                renderKunciJawaban(
                    data.question_model,
                    data.kunci_jawaban
                );


            }
        })
    }


    $("#form-simpan").submit(function(e) {
        e.preventDefault();
        showLoading();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('tka_detail') }}";
        else url = "{{ url('tka_detail') . '/' }}" + id;

        var form_data = new FormData($('#modal-add form')[0]);
        var soal = CKEDITOR.instances.soal.getData();
        var soalBawah = CKEDITOR.instances.soal_bawah.getData();
        var jawabanA = CKEDITOR.instances.jawaban_a.getData();
        var jawabanB = CKEDITOR.instances.jawaban_b.getData();
        var jawabanC = CKEDITOR.instances.jawaban_c.getData();
        var jawabanD = CKEDITOR.instances.jawaban_d.getData();
        var jawabanE = CKEDITOR.instances.jawaban_e.getData();
        form_data.append('soal', soal);
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
                hideLoading();
                if (data.success == true) {
                    $('#modal-add').modal('hide');
                    table.ajax.reload(null, false);
                    $("#loadingProgress").hide();

                } else {
                    var messages = '';

                    $.each(data.message, function(key, value) {

                        if (Array.isArray(value)) {
                            messages += value[0] + '\n';
                        } else {
                            messages += value + '\n';
                        }

                    });

                    alert(messages);
                }
            }

        });
    });


    function deleteImage(id, ind) {
        var hapus = confirm('Hapus Gambar Ini...?');
        if (hapus === true) {
            confirmHapusImage(id, ind);
        }
    }

    function confirmHapusImage(id, type) {

        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('delete_tka_image') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                'id': id,
                'type': type,
                '_token': csrf_token
            },
            success: function(data) {

                table.ajax.reload(null, false);

            }
        })
    }


    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }

    function deleteDataConfirm() {
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('tka_detail') }}" + "/" + id,
            type: "POST",
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

    function deleteDataAll() {
        $("#modal-hapus-semua").modal("show");
    }

    function deleteAllDataConfirm() {
        var id = $("#id_hapus_semua").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('detail_delete_all') }}",
            type: "POST",
            data: {
                'id': id,
                '_token': csrf_token
            },
            success: function(data) {
                table.ajax.reload(null, false);
                $("#modal-hapus-semua").modal("hide");
            }
        });
    }


    function resetForm() {
        $('#form-simpan')[0].reset();
        $("#label_kunci_jawaban").hide();
        $("#kunci_jawaban_container").html('');
        $("#jawaban_container").hide();
        kosongkanEditor();
    }

    function showLoading() {
        $("#btn-submit").prop("disbaled", true);
        $("#btn-submit").text('Processing...');
    }


    function hideLoading() {
        $("#btn-submit").prop("disbaled", false);
        $("#btn-submit").text('Save Changes');
    }


    function kosongkanEditor() {
        CKEDITOR.instances.soal.setData("");
        CKEDITOR.instances.soal_bawah.setData("");
        CKEDITOR.instances.jawaban_a.setData("");
        CKEDITOR.instances.jawaban_b.setData("");
        CKEDITOR.instances.jawaban_c.setData("");
        CKEDITOR.instances.jawaban_d.setData("");
        CKEDITOR.instances.jawaban_e.setData("");
    }
</script>
