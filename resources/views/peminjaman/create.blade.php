{{-- <form action="{{ url('/peminjaman/store_rekomendasi') }}" method="POST" id="form-peminjaman" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Peminjaman Kendaraan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Kendaraan -->
                <div class="form-group">
                    <label>Pilih Kendaraan</label>
                    <select name="id_kendaraan" id="id_kendaraan" class="form-control" required>
                        <option value="">- Pilih Kendaraan -</option>
                        @foreach ($kendaraan as $k)
                            <option value="{{ $k->id_kendaraan }}">{{ $k->nama_kendaraan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Perusahaan -->
                <div class="form-group">
                    <label>Pilih Perusahaan</label>
                    <select name="id_perusahaan" id="id_perusahaan" class="form-control" required>
                        <option value="">- Pilih Perusahaan -</option>
                        @foreach ($perusahaan as $p)
                            <option value="{{ $p->id_perusahaan }}">{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Driver -->
                <div class="form-group">
                    <label>Pilih Driver</label>
                    <select name="driver_id" id="driver_id" class="form-control" required>
                        <option value="">- Pilih Driver -</option>
                    </select>
                </div>

                <!-- Koordinator -->
                <div class="form-group">
                    <label>Pilih Koordinator</label>
                    <select name="koordinator_id" id="koordinator_id" class="form-control" required>
                        <option value="">- Pilih Koordinator -</option>
                    </select>
                </div>

                <!-- Nama Peminjaman -->
                <div class="form-group">
                    <label>Nama Peminjaman</label>
                    <input type="text" name="nama_peminjaman" id="nama_peminjaman" class="form-control" required>
                </div>

                <!-- Tujuan Peminjaman -->
                <div class="form-group">
                    <label>Tujuan Peminjaman</label>
                    <textarea name="tujuan_peminjaman" id="tujuan_peminjaman" class="form-control" required></textarea>
                </div>

                <!-- Tanggal Peminjaman -->
                <div class="form-group">
                    <label>Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="form-control" required>
                </div>

                <!-- Tanggal Berakhir -->
                <div class="form-group">
                    <label>Tanggal Berakhir Peminjaman</label>
                    <input type="date" name="tanggal_berakhir_peminjaman" id="tanggal_berakhir_peminjaman" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $("#id_kendaraan, #id_perusahaan, #driver_id, #koordinator_id").select2({
            theme: "classic",
            width: "100%"
        });

        // Load Driver
        $.ajax({
            url: "{{ url('/peminjaman') }}",
            type: "GET",
            data: { level: 2 }, // id_level untuk Driver
            success: function(response) {
                if (response.status) {
                    const driverOptions = response.data.map(driver =>
                        `<option value="${driver.user_id}">${driver.nama}</option>`
                    ).join('');
                    $('#driver_id').html('<option value="">- Pilih Driver -</option>' + driverOptions);
                }
            }
        });

        // Load Koordinator
        $.ajax({
            url: "{{ url('/peminjaman') }}",
            type: "GET",
            data: { level: 3 }, // id_level untuk Koordinator
            success: function(response) {
                if (response.status) {
                    const koordinatorOptions = response.data.map(koordinator =>
                        `<option value="${koordinator.user_id}">${koordinator.nama}</option>`
                    ).join('');
                    $('#koordinator_id').html('<option value="">- Pilih Koordinator -</option>' + koordinatorOptions);
                }
            }
        });

        // Validasi Form
        $("#form-peminjaman").validate({
            rules: {
                id_kendaraan: { required: true },
                id_perusahaan: { required: true },
                driver_id: { required: true },
                koordinator_id: { required: true },
                nama_peminjaman: { required: true, minlength: 3 },
                tujuan_peminjaman: { required: true, minlength: 5 },
                tanggal_peminjaman: { required: true },
                tanggal_berakhir_peminjaman: { required: true, after: "#tanggal_peminjaman" }
            },
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                element.closest(".form-group").append(error);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });
    });
</script> --}}



{{-- 
<form action="{{ url('/peminjaman/store') }}" method="POST" id="form-peminjaman" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Peminjaman Kendaraan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Pilih Kendaraan -->
                <div class="form-group">
                    <label>Pilih Kendaraan</label>
                    <select name="id_kendaraan" id="id_kendaraan" class="form-control" required>
                        <option value="">- Pilih Kendaraan -</option>
                        @foreach ($kendaraan as $k)
                            <option value="{{ $k->id_kendaraan }}">{{ $k->nama_kendaraan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Perusahaan -->
                <div class="form-group">
                    <label>Pilih Perusahaan</label>
                    <select name="id_perusahaan" id="id_perusahaan" class="form-control" required>
                        <option value="">- Pilih Perusahaan -</option>
                        @foreach ($perusahaan as $p)
                            <option value="{{ $p->id_perusahaan }}">{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="driver">Pilih Driver</label>
                    <select name="driver" id="driver" class="form-control">
                        <option value="">-- Pilih Driver --</option>
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->user_id }}">{{ $driver->nama }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group">
                    <label for="koordinator">Pilih Koordinator</label>
                    <select name="koordinator" id="koordinator" class="form-control">
                        <option value="">-- Pilih Koordinator --</option>
                        @foreach ($koordinators as $koordinator)
                            <option value="{{ $koordinator->user_id }}">{{ $koordinator->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Peminjaman -->
                <div class="form-group">
                    <label>Nama Peminjaman</label>
                    <input type="text" name="nama_peminjaman" id="nama_peminjaman" class="form-control" required>
                </div>

                <!-- Tujuan Peminjaman -->
                <div class="form-group">
                    <label>Tujuan Peminjaman</label>
                    <textarea name="tujuan_peminjaman" id="tujuan_peminjaman" class="form-control" required></textarea>
                </div>

                <!-- Tanggal Peminjaman -->
                <div class="form-group">
                    <label>Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="form-control" required>
                </div>

                <!-- Tanggal Berakhir -->
                <div class="form-group">
                    <label>Tanggal Berakhir Peminjaman</label>
                    <input type="date" name="tanggal_berakhir_peminjaman" id="tanggal_berakhir_peminjaman" class="form-control" required>
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
    $(document).ready(function() {
        // Inisialisasi Select2
        $("#id_kendaraan, #id_perusahaan, #driver, #koordinator").select2({
            theme: "classic",
            width: "100%"
        });
    });
</script>
 --}}

{{-- 
 <form action="{{ url('/peminjaman/store') }}" method="POST" id="form-peminjaman" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Peminjaman Kendaraan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Pilih Kendaraan -->
                <div class="form-group">
                    <label>Pilih Kendaraan</label>
                    <select name="id_kendaraan" id="id_kendaraan" class="form-control" required>
                        <option value="">- Pilih Kendaraan -</option>
                        @foreach ($kendaraan as $k)
                            <option value="{{ $k->id_kendaraan }}">{{ $k->nama_kendaraan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_kendaraan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Pilih Perusahaan -->
                <div class="form-group">
                    <label>Pilih Perusahaan</label>
                    <select name="id_perusahaan" id="id_perusahaan" class="form-control" required>
                        <option value="">- Pilih Perusahaan -</option>
                        @foreach ($perusahaan as $p)
                            <option value="{{ $p->id_perusahaan }}">{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_perusahaan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Pilih Driver -->
<!-- Driver -->
<div class="form-group">
    <label>Pilih Driver</label>
    <select name="driver_id" id="driver_id" class="form-control" required>
        <option value="">- Pilih Driver -</option>
        @foreach ($drivers as $driver)
            <option value="{{ $driver->user_id }}">{{ $driver->nama }}</option>
        @endforeach
    </select>
</div>

<!-- Koordinator -->
<div class="form-group">
    <label>Pilih Koordinator</label>
    <select name="koordinator_id" id="koordinator_id" class="form-control" required>
        <option value="">- Pilih Koordinator -</option>
        @foreach ($koordinators as $koordinator)
            <option value="{{ $koordinator->user_id }}">{{ $koordinator->nama }}</option>
        @endforeach
    </select>
</div>


                <!-- Nama Peminjaman -->
                <div class="form-group">
                    <label>Nama Peminjaman</label>
                    <input type="text" name="nama_peminjaman" id="nama_peminjaman" class="form-control" required>
                    <small id="error-nama_peminjaman" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tujuan Peminjaman -->
                <div class="form-group">
                    <label>Tujuan Peminjaman</label>
                    <textarea name="tujuan_peminjaman" id="tujuan_peminjaman" class="form-control" required></textarea>
                    <small id="error-tujuan_peminjaman" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Peminjaman -->
                <div class="form-group">
                    <label>Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="form-control" required>
                    <small id="error-tanggal_peminjaman" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Berakhir -->
                <div class="form-group">
                    <label>Tanggal Berakhir Peminjaman</label>
                    <input type="date" name="tanggal_berakhir_peminjaman" id="tanggal_berakhir_peminjaman" class="form-control" required>
                    <small id="error-tanggal_berakhir_peminjaman" class="error-text form-text text-danger"></small>
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
    $(document).ready(function() {
        // Inisialisasi Select2
        $("#id_kendaraan, #id_perusahaan, #driver_id, #koordinator_id").select2({
            theme: "classic",
            width: "100%"
        });

        // Validasi Form
        $("#form-peminjaman").validate({
            rules: {
                id_kendaraan: { required: true },
                id_perusahaan: { required: true },
                driver_id: { required: true },
                koordinator_id: { required: true },
                nama_peminjaman: { required: true, minlength: 3 },
                tujuan_peminjaman: { required: true, minlength: 5 },
                tanggal_peminjaman: { required: true },
                tanggal_berakhir_peminjaman: { required: true }
            },
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                element.closest(".form-group").append(error);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });
    });
</script> --}}


<form action="{{ url('/peminjaman/store') }}" method="POST" id="form-peminjaman" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Peminjaman Kendaraan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Pilih Kendaraan -->
                <div class="form-group">
                    <label>Pilih Kendaraan</label>
                    <select name="id_kendaraan" id="id_kendaraan" class="form-control" required>
                        <option value="">- Pilih Kendaraan -</option>
                        @foreach ($kendaraan as $k)
                            <option value="{{ $k->id_kendaraan }}">{{ $k->nama_kendaraan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_kendaraan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Pilih Perusahaan -->
                <div class="form-group">
                    <label>Pilih Perusahaan</label>
                    <select name="id_perusahaan" id="id_perusahaan" class="form-control" required>
                        <option value="">- Pilih Perusahaan -</option>
                        @foreach ($perusahaan as $p)
                            <option value="{{ $p->id_perusahaan }}">{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_perusahaan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Pilih Driver -->
                <div class="form-group">
                    <label>Pilih Driver</label>
                    <select name="driver_id" id="driver_id" class="form-control" required>
                        <option value="">- Pilih Driver -</option>
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->user_id }}">{{ $driver->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-driver_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Pilih Koordinator -->
                <div class="form-group">
                    <label>Pilih Koordinator</label>
                    <select name="koordinator_id" id="koordinator_id" class="form-control" required>
                        <option value="">- Pilih Koordinator -</option>
                        @foreach ($koordinators as $koordinator)
                            <option value="{{ $koordinator->user_id }}">{{ $koordinator->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-koordinator_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Pilih Jenis Kendaraan</label>
                    <select name="id_jenis_kendaraan" id="id_jenis_kendaraan" class="form-control" required>
                        <option value="">- Pilih Jenis Kendaraan -</option>
                        @foreach ($jenisKendaraan as $jenis)
                            <option value="{{ $jenis->id_jenis_kendaraan }}">{{ $jenis->nama_jenis_kendaraan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenis_kendaraan" class="error-text form-text text-danger"></small>
                </div>
                

                <!-- Nama Peminjaman -->
                <div class="form-group">
                    <label>Nama Peminjaman</label>
                    <input type="text" name="nama_peminjaman" id="nama_peminjaman" class="form-control" required>
                    <small id="error-nama_peminjaman" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tujuan Peminjaman -->
                <div class="form-group">
                    <label>Tujuan Peminjaman</label>
                    <textarea name="tujuan_peminjaman" id="tujuan_peminjaman" class="form-control" required></textarea>
                    <small id="error-tujuan_peminjaman" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Peminjaman -->
                <div class="form-group">
                    <label>Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="form-control" required>
                    <small id="error-tanggal_peminjaman" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Berakhir -->
                <div class="form-group">
                    <label>Tanggal Berakhir Peminjaman</label>
                    <input type="date" name="tanggal_berakhir_peminjaman" id="tanggal_berakhir_peminjaman" class="form-control" required>
                    <small id="error-tanggal_berakhir_peminjaman" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
{{-- 
<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $("#id_kendaraan, #id_perusahaan, #driver_id, #koordinator_id").select2({
            theme: "classic",
            width: "100%"
        });

        // Validasi Form
        $("#form-peminjaman").validate({
            rules: {
                id_kendaraan: { required: true },
                id_perusahaan: { required: true },
                driver_id: { required: true },
                koordinator_id: { required: true },
                nama_peminjaman: { required: true, minlength: 3 },
                tujuan_peminjaman: { required: true, minlength: 5 },
                tanggal_peminjaman: { required: true, date: true },
                tanggal_berakhir_peminjaman: { required: true, date: true }
            },
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                element.closest(".form-group").append(error);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });
    });
</script> --}}

<script>
$(document).ready(function() {
    // Inisialisasi Select2
    $("#id_kendaraan, #id_perusahaan, #driver_id, #koordinator_id, #id_jenis_kendaraan").select2({
        theme: "classic",
        width: "100%"
    });

    // Validasi dan AJAX untuk form
    $("#form-peminjaman").validate({
        rules: {
            id_kendaraan: { required: true },
            id_perusahaan: { required: true },
            driver_id: { required: true },
            koordinator_id: { required: true },
            id_jenis_kendaraan: { required: true },
            nama_peminjaman: { required: true, minlength: 3 },
            tujuan_peminjaman: { required: true, minlength: 5 },
            tanggal_peminjaman: { required: true, date: true },
            tanggal_berakhir_peminjaman: { required: true, date: true }
        },
        submitHandler: function(form) {
            $.ajax({
                url: form.action, // Endpoint dari form
                type: form.method, // Metode POST
                data: $(form).serialize(), // Serialize data form
                beforeSend: function() {
                    // Tombol submit dalam keadaan loading
                    $(".btn-primary").attr("disabled", true).text("Menyimpan...");
                },
                success: function(response) {
                    if (response.status) {
                        // Jika berhasil, modal ditutup dan alert ditampilkan
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(() => {
                            location.reload(); // Reload halaman setelah berhasil
                        });
                    } else {
                        // Jika ada kesalahan validasi
                        $('.error-text').text(''); // Reset semua error message
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]); // Tampilkan error spesifik
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    // Jika error dari server
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: xhr.responseJSON.message || "Gagal menyimpan data."
                    });
                },
                complete: function() {
                    // Kembalikan tombol submit ke keadaan normal
                    $(".btn-primary").attr("disabled", false).text("Simpan");
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