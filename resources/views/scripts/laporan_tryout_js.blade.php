<script>
    function tampilkan_laporan_tryout() {
        var id = $("#id_kelas").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $("#loadingProgress").show();
        $.ajax({
            url: "{{ url('display_tryout_report') }}",
            type: "POST",
            dataType: "HTML",
            data: {
                'id': id,
                '_token': csrf_token
            },
            success: function(data) {
                $("#loadingProgress").hide();
                $("#isi_laporan_tryout").html(data);
            }
        })
    }
</script>
