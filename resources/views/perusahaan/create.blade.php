<form action="{{ url('/perusahaan/store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Perusahaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Kode Perusahaan -->
                <div class="form-group">
                    <label>Kode Perusahaan</label>
                    <input type="text" name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                    <small id="error-kode_perusahaan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Nama Perusahaan -->
                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" required>
                    <small id="error-nama_perusahaan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Lokasi -->
                <div class="form-group">
                    <label>Lokasi</label>
                    <textarea name="lokasi" id="lokasi" class="form-control" rows="3" required></textarea>
                    <small id="error-lokasi" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn"
                    style="color: #EF5428; background-color: white; border-color: #EF5428;">Batal</button>
                <button type="submit" class="btn"
                    style="color: white; background-color: #EF5428; border-color: #EF5428;">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#form-tambah").validate({
            rules: {
                kode_perusahaan: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                nama_perusahaan: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                lokasi: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                kode_perusahaan: {
                    required: "Kode perusahaan wajib diisi.",
                    minlength: "Kode perusahaan minimal 3 karakter.",
                    maxlength: "Kode perusahaan maksimal 50 karakter."
                },
                nama_perusahaan: {
                    required: "Nama perusahaan wajib diisi.",
                    minlength: "Nama perusahaan minimal 3 karakter.",
                    maxlength: "Nama perusahaan maksimal 255 karakter."
                },
                lokasi: {
                    required: "Lokasi wajib diisi.",
                    minlength: "Lokasi minimal 3 karakter."
                }
            },
            submitHandler: function (form) {
                let formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataPerusahaan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
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
            }
        });
    });
</script>
