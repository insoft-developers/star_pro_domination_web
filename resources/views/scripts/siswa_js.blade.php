<script>
    function contactData(id) {
        window.location = "{{ url('contact_list') }}" + "/" + id;
    }

    var table = $('#siswa_table').DataTable({
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
        ajax: "{{ route('siswaTable') }}",
        order: [
            [1, "desc"]
        ],
        columns: [{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'version',
                name: 'version'
            },
            {
                data: 'profile_image',
                name: 'profile_image'
            },
            {
                data: 'is_active',
                name: 'is_active'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'last_action',
                name: 'last_action'
            },
            {
                data: 'nis',
                name: 'nis'
            },
            {
                data: 'id_kelas',
                name: 'id_kelas'
            },
            {
                data: 'school_id',
                name: 'school_id'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'phone',
                name: 'phone'
            },


        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $("#password").attr("required", true);
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Siswa");
        $("#modal-add").modal("show");
    }


    function editData(id) {
        showLoading();
        save_method = "edit";
        $("#password").removeAttr("required");
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
            url: "{{ url('siswa') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                hideLoading();
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Data Siswa");
                $('#id').val(data.id);
                $("#name").val(data.name);
                $("#id_kelas").val(data.id_kelas);
                $("#email").val(data.email);
                $("#phone").val(data.phone);
                $("#is_active").val(data.is_active);
                $("#school_id").val(data.school_id);
                $("#nis").val(data.nis);

            }
        })
    }



    $("#form-simpan").submit(function(e) {
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('siswa') }}";
        else url = "{{ url('siswa') . '/' }}" + id;
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
            url: "{{ url('siswa') }}" + '/' + id,
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


    function resetForm() {
        $("#profile_image").val(null);
        $("#name").val("");
        $("#id_kelas").val("");
        $("#email").val("");
        $("#phone").val("");
        $("#password").val("");
        $("#nis").val("");
    }


    function showLoading() {
        $("#loadingProgress").show();
    }


    function hideLoading() {
        $("#loadingProgress").hide();
    }

    function logoutData(id) {
        var popup = confirm('Apakah anda ingin ubah status user menjadi logout..?');
        if (popup === true) {
            logoutDataConfirm(id);
        }
    }

    function logoutDataConfirm(id) {
        $.ajax({
            url: "{{ url('logout_data_user') }}" + "/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                table.ajax.reload(null, false);
            }
        });
    }
</script>
