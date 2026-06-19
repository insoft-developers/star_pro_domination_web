 <script>
        $("#form-profile").submit(function(e) {
            $("#loadingProgress").show();
            e.preventDefault();
            var id = $('#id').val();
            $.ajax({
                url: "{{ url('profile_update') }}",
                type: "POST",
                data: new FormData($('form')[0]),
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success == true) {

                        $("#loadingProgress").hide();
                        window.location = "{{ url('profile') }}";
                    }
                }

            });
        });
    </script>