 <script>
            function activeData(id) {
                $.ajax({
                    url: "{{ url('setting_active') }}" + "/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        window.location = "{{ url('setting') }}";
                    }
                })
            }

            function saveData() {
                var wa = $("#whatsapp").val();
                var insta = $("#instagram").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('update_sosmed') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        "wa": wa,
                        "insta": insta,
                        "_token": csrf_token
                    },
                    success: function(data) {
                        $("#btn_save").hide();
                        $("#btn_edit").show();
                        $("#whatsapp").hide();
                        $("#instagram").hide();
                        $("#wa-text").text(wa);
                        $("#insta-text").text(insta);
                        $("#wa-text").show();
                        $("#insta-text").show();

                        alert("Contact Data Updated Successfully");
                    }

                });
            }


            function editData() {
                $("#btn_edit").hide();
                $("#btn_save").show();
                $("#whatsapp").show();
                $("#instagram").show();
                $("#wa-text").hide();
                $("#insta-text").hide();
            }


            function inactiveData(id) {
                $.ajax({
                    url: "{{ url('setting_inactive') }}" + "/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        window.location = "{{ url('setting') }}";
                    }
                })
            }
        </script>