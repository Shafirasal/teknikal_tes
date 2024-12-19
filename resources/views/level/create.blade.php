<form action="{{ url('/level/store') }}" method="POST" id="form-tambah-level">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Level</label>
                    <input value="" type="text" name="kode_level" id="kode_level" class="form-control" required>
                    <small id="error-kode_level" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Level</label>
                    <input value="" type="text" name="nama_level" id="nama_level" class="form-control" required>
                    <small id="error-nama_level" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn" style="color: #EF5428; background-color: white; border-color: #EF5428;">Batal</button>
            <button type="submit" class="btn"style="color: white; background-color: #EF5428; border-color: #EF5428;">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-tambah-level").validate({
            rules: {
                kode_level: {
                    required: true,
                    minlength: 2,
                    maxlength: 10
                },
                nama_level: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataLevel.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>