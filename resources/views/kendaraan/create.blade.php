<form action="{{ url('/kendaraan/store') }}" method="POST" id="form-tambah-kendaraan">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kendaraan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Jenis Kendaraan -->
                <div class="form-group">
                    <label>Jenis Kendaraan</label>
                    <select name="id_jenis_kendaraan" id="id_jenis_kendaraan" class="form-control" required>
                        <option value="">- Pilih Jenis Kendaraan -</option>
                        @foreach ($jenis_kendaraan as $jenis)
                            <option value="{{ $jenis->id_jenis_kendaraan }}">{{ $jenis->nama_jenis_kendaraan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenis_kendaraan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Nama Kendaraan -->
                <div class="form-group">
                    <label>Nama Kendaraan</label>
                    <input type="text" name="nama_kendaraan" id="nama_kendaraan" class="form-control" required>
                    <small id="error-nama_kendaraan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Nomor Kendaraan -->
                <div class="form-group">
                    <label>Nomor Kendaraan</label>
                    <input type="text" name="no_kendaraan" id="no_kendaraan" class="form-control" required>
                    <small id="error-no_kendaraan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Produksi -->
                <div class="form-group">
                    <label>Tanggal Produksi Kendaraan</label>
                    <input type="date" name="tanggal_produksi_kendaraan" id="tanggal_produksi_kendaraan" class="form-control" required>
                    <small id="error-tanggal_produksi_kendaraan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">- Pilih Status -</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="dalam pemakaian">Dalam Pemakaian</option>
                        <option value="diservice">Diservice</option>
                    </select>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        // Validasi form menggunakan jQuery Validate
        $("#form-tambah-kendaraan").validate({
            rules: {
                id_jenis_kendaraan: {
                    required: true
                },
                nama_kendaraan: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                no_kendaraan: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                tanggal_produksi_kendaraan: {
                    required: true,
                    date: true
                },
                status: {
                    required: true
                }
            },
            messages: {
                id_jenis_kendaraan: {
                    required: "Jenis kendaraan harus dipilih."
                },
                nama_kendaraan: {
                    required: "Nama kendaraan harus diisi.",
                    minlength: "Nama kendaraan minimal 3 karakter.",
                    maxlength: "Nama kendaraan maksimal 100 karakter."
                },
                no_kendaraan: {
                    required: "Nomor kendaraan harus diisi.",
                    minlength: "Nomor kendaraan minimal 3 karakter.",
                    maxlength: "Nomor kendaraan maksimal 20 karakter."
                },
                tanggal_produksi_kendaraan: {
                    required: "Tanggal produksi harus diisi.",
                    date: "Tanggal produksi harus berupa tanggal yang valid."
                },
                status: {
                    required: "Status kendaraan harus dipilih."
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataKendaraan.ajax.reload();
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
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
