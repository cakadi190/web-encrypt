<!DOCTYPE html>
<html lang="id-ID">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Encrypt Your File!</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
</head>

<body>
  <div class="container py-5 min-vh-100">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card rounded-4 overflow-hidden">
          <div class="card-img-top overflow-hidden relative rounded-top-4" style="height: 100px;">
            <img class="w-100 object-fit-cover" src="assets/images/compressed.jpg" alt="Cover" />

            <div class="position-absolute p-3 d-flex flex-column align-items-center justify-content-center"
              style="top: 0; left: 0; right: 0; bottom: 0; height: 100px; width: 100%; background: rgba(0, 0, 0, 0.25); backdrop-filter: blur(5px);">
              <h1 class="text-white display-5 fw-bold mb-2 text-center">Encrypt Your File!</h1>
            </div>
          </div>
          <div class="card-header bg-white">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#panduan">Panduan</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#enkripsi">Enkripsi</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dekripsi">Dekripsi</button>
              </li>
            </ul>
          </div>
          <div class="card-body tab-content">
            <div class="tab-pane fade show active" id="panduan">
              <div class="card-body card">
                <h2 class="h5">Panduan Penggunaan</h2>
                <p>Silahkan gunakan perkakas ini dengan benar dan tidak digunakan untuk menjaili atau merusak sistem
                  orang lain. Format yang didukung:</p>

                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <ul class="list-group list-group-flush" id="format-list-1">
                    </ul>
                  </div>
                  <div class="col-md-6">
                    <ul class="list-group list-group-flush" id="format-list-2">
                    </ul>
                  </div>
                </div>

                <p>Dengan mengenkripsi gambar menggunakan Algoritma Base64 dalam metode proses encode dan decode,
                  pengamanan gambar akan lebih aman karena tidak sembarang orang dapat melihat gambar tersebut.</p>
                <p class="mb-0">Silahkan mulai menggunakan perkakas ini dengan menekan salah satu tab diatas.</p>
              </div>
            </div>
            <div class="tab-pane fade" id="enkripsi">
              <div class="card card-body">
                <h2 class="h5">Enkripsi</h2>
                <p>Silahkan unggah berkas yang sesuai dengan format untuk dienkripsikan dan maksimal ukuran berkasnya
                  adalah 5MB (atau 5120KB).</p>

                <form action="./process.php" id="post-encrypt" enctype="multipart/form-data" method="POST"
                  class="needs-validation" novalidate>
                  <div class="form-group mb-3">
                    <label for="file" class="form-label">Pilih berkas</label>
                    <input type="file" name="file" id="file" data-max-size="5242880" class="form-control"
                      accept="image/*" required>
                    <div class="invalid-feedback">Harap isi dengan data yang benar.</div>
                  </div>
                  <button class="btn btn-primary" type="submit">Enkripsi</button>
                </form>

                <div class="collapse" id="resultEncrypted">
                  <h3 class="h6 mt-3">Hasil Enkripsi</h3>

                  <div class="form-group mb-3">
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="fas fa-key fa-fw"></i>
                      </span>
                      <input type="text" id="iv-result" readonly class="form-control" placeholder="Hasil Enkripsi" />
                      <button class="btn btn-light" onclick="copyToClipboard('#iv-result', this)"><i
                          class="fas fa-copy fa-fw"></i></button>
                    </div>
                    <div class="form-text">Mohon simpan kunci ini dengan baik untuk didekripsikan nanti.</div>
                  </div>

                  <div class="d-flex justify-content-start">
                    <a class="btn btn-primary d-flex align-items-center gap-2" id="download-link">
                      <i class="fas fa-download fa-fw"></i>
                      <span>Unduh Hasil Enkripsi</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="dekripsi">
              <div class="card card-body">
                <h2 class="h5">Dekripsi</h2>
                <p>Silahkan masukkan kunci enkripsi dan berkas yang ingin didekripsi.</p>

                <form action="./process.php" id="post-decrypt" enctype="multipart/form-data" method="POST"
                  class="needs-validation" novalidate>
                  <div class="form-group mb-3">
                    <label for="iv" class="form-label">Masukkan kunci enkripsi</label>
                    <input type="text" name="iv" id="iv" class="form-control" required>
                    <div class="invalid-feedback">Harap isi dengan data yang benar.</div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="file" class="form-label">Pilih berkas</label>
                    <input type="file" name="file" id="file" data-max-size="5242880" class="form-control" accept=".enc"
                      required />
                    <div class="invalid-feedback">Harap isi dengan data yang benar.</div>
                  </div>
                  <button class="btn btn-primary" type="submit">Dekripsi</button>
                </form>

                <div class="collapse" id="resultDecrypted">
                  <h3 class="h6 mt-3">Hasil Dekripsi</h3>
                  <div class="form-group">
                    <img id="img-result" class="border d-block mx-auto mb-2" src="" alt="Hasil Dekripsi" style="max-width: 100%;" />
                    <div><small class="form-text">Untuk mengunduh gambar diatas, silahkan (untuk laptop/pc) klik kanan lalu simpan (untuk mobile/phone) tahan gambar sampai muncul menu opsi, lalu unduh gambar.</small></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <script>
    const supportedFormats = [
      { name: 'PNG', icon: './assets/images/png.png' },
      { name: 'JPG', icon: './assets/images/jpg.png' },
      { name: 'JPEG', icon: './assets/images/jpeg.png' },
      { name: 'PSD', icon: './assets/images/psd.png' },
      { name: 'GIF', icon: './assets/images/gif.png' },
      { name: 'BMP', icon: './assets/images/bmp.png' }
    ];

    function createFormatListItem(format) {
      return `
    <li class="list-group-item d-flex gap-2 align-items-center">
      <img src="${format.icon}" alt="Icon ${format.name}" style="height: 32px;aspect-ratio: 1/1">
      <span><code>File ${format.name}</code></span>
    </li>
  `;
    }

    const midPoint = Math.ceil(supportedFormats.length / 2);
    document.getElementById('format-list-1').innerHTML = supportedFormats
      .slice(0, midPoint)
      .map(createFormatListItem)
      .join('');
    document.getElementById('format-list-2').innerHTML = supportedFormats
      .slice(midPoint)
      .map(createFormatListItem)
      .join('');

    document.addEventListener('DOMContentLoaded', () => {
      const forms = document.querySelectorAll('.needs-validation');

      const fileInputs = document.querySelectorAll('input[type="file"][data-max-size]');
      fileInputs.forEach(input => {
        input.addEventListener('change', function () {
          validateFileSize(this);
        });
      });

      forms.forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          } else {
            if (form.id === 'post-encrypt') {
              validateFile(event, form);
              doUploadEncrypt(event);
            } else if (form.id === 'post-decrypt') {
              doUploadDecrypt(event);
            }
          }
          form.classList.add('was-validated');
        });
      });
    });

    function doUploadEncrypt(event) {
      event.preventDefault();
      const form = event.target;

      const formData = new FormData(form);
      formData.append("type", "encrypt");

      $.ajax({
        url: './process.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
          $('#iv-result').val('');
          $('#resultEncrypted').toggle(false);
          $('#download-link').attr('href', ``);
          $(form).find('button').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
          $(form).find('button').attr('disabled', true);
        },
        success: function (data) {
          const result = data.data;
          $('#resultEncrypted').toggle(!!result.iv);
          $('#iv-result').val(`${result.iv},${result.extension}`);
          $('#download-link').attr('href', `./download.php?filename=${result.fileName}`);

          $(form).find('button').html('Enkripsi');
          $(form).find('button').removeAttr('disabled');
        },
        error: function (error) {
          console.log(error);
          $('#iv-result').val('');
          $('#resultEncrypted').toggle(false);
          $('#download-link').attr('href', ``);
          $(form).find('button').html('Enkripsi');
          $(form).find('button').removeAttr('disabled');
        }
      });
    }

    function doUploadDecrypt(event) {
      event.preventDefault();
      const form = event.target;

      const formData = new FormData(form);
      formData.append("type", "encrypt");

      $.ajax({
        url: './process.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
          $('#iv-result').val('');
          $('#resultEncrypted').toggle(false);
          $('#download-link').attr('href', ``);
          $(form).find('button').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
          $(form).find('button').attr('disabled', true);
        },
        success: function (data) {
          const result = data.data;
          $('#resultEncrypted').toggle(!!result.iv);
          $('#iv-result').val(result.iv);
          $('#download-link').attr('href', `./download.php?filename=${result.fileName}`);

          $(form).find('button').html('Enkripsi');
          $(form).find('button').removeAttr('disabled');
        },
        error: function (error) {
          console.log(error);
          $('#iv-result').val('');
          $('#resultEncrypted').toggle(false);
          $('#download-link').attr('href', ``);
          $(form).find('button').html('Enkripsi');
          $(form).find('button').removeAttr('disabled');
        }
      });
    }

    function doUploadDecrypt(event) {
      event.preventDefault();
      const form = event.target;

      // Validasi kunci enkripsi
      const ivInput = form.querySelector('#iv');
      if (!ivInput.value.trim()) {
        ivInput.classList.add('is-invalid');
        ivInput.setCustomValidity('Kunci enkripsi tidak boleh kosong');
        ivInput.reportValidity();
        return;
      }

      const fileInput = form.querySelector('input[type="file"]');
      const file = fileInput.files[0];

      // Validasi file
      if (!file) {
        fileInput.classList.add('is-invalid');
        fileInput.setCustomValidity('Harap pilih file untuk didekripsi');
        fileInput.reportValidity();
        return;
      }

      // Validasi ekstensi file
      const fileName = file.name.toLowerCase();
      if (!fileName.endsWith('.enc')) {
        fileInput.classList.add('is-invalid');
        fileInput.setCustomValidity('Hanya file dengan ekstensi .enc yang diperbolehkan');
        fileInput.reportValidity();
        return;
      }

      // Validasi ukuran file
      const maxSize = parseInt(fileInput.dataset.maxSize);
      if (file.size > maxSize) {
        fileInput.classList.add('is-invalid');
        fileInput.setCustomValidity(`Ukuran file terlalu besar. Maksimal ukuran file adalah ${(maxSize / (1024 * 1024)).toFixed()}MB`);
        fileInput.reportValidity();
        return;
      }

      const formData = new FormData(form);
      formData.append("type", "decrypt");

      $.ajax({
        url: './process.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
          // Reset validasi
          ivInput.classList.remove('is-invalid');
          fileInput.classList.remove('is-invalid');

          $('#resultDecrypted').toggle(false);
          $('#img-result').attr('src', '');
          $(form).find('button').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
          $(form).find('button').attr('disabled', true);
        },
        success: function (data) {
          const result = data.data;

          if (result && result.result) {
            $('#resultDecrypted').toggle(true);
            $('#img-result').attr('src', `data:image/${result.extension ?? 'jpeg'};base64,${result.result}`);
          } else {
            // Tambahkan penanganan kesalahan jika dekripsi gagal
            alert('Dekripsi gagal. Pastikan kunci dan file enkripsi benar.');
          }

          $(form).find('button').html('Dekripsi');
          $(form).find('button').removeAttr('disabled');
        },
        error: function (error) {
          console.error(error);

          // Tampilkan pesan kesalahan yang lebih informatif
          alert('Terjadi kesalahan dalam proses dekripsi. Silakan coba lagi.');

          $('#resultDecrypted').toggle(false);
          $('#img-result').attr('src', '');
          $(form).find('button').html('Dekripsi');
          $(form).find('button').removeAttr('disabled');
        }
      });
    }

    function validateFileSize(input) {
      const maxSize = parseInt(input.dataset.maxSize);
      const file = input.files[0];

      input.classList.remove('is-invalid');
      const feedback = input.nextElementSibling;

      if (file && file.size > maxSize) {
        input.value = '';
        input.classList.add('is-invalid');
        feedback.textContent = `Ukuran file terlalu besar. Maksimal ukuran file adalah ${(maxSize / (1024 * 1024)).toFixed()}MB.`;
        return false;
      }

      return true;
    }

    function validateFile(event, form) {
      const fileInput = form.querySelector('input[type="file"]');
      if (!fileInput) return;

      const file = fileInput.files[0];
      const acceptedTypes = fileInput.accept.split(',');

      fileInput.classList.remove('is-invalid');
      const feedback = fileInput.nextElementSibling;

      if (!file) {
        setInvalid('Harap pilih file.');
        return;
      }

      if (!file.type.startsWith('image/')) {
        setInvalid('Harap unggah file gambar yang valid.');
        return;
      }

      if (!validateFileSize(fileInput)) {
        event.preventDefault();
        return;
      }

      const extension = file.name.split('.').pop().toLowerCase();
      const validExtensions = supportedFormats.map(f => f.name.toLowerCase());

      if (!validExtensions.includes(extension)) {
        setInvalid(`Format file tidak valid. Format yang didukung: ${validExtensions.join(', ')}`);
        return;
      }

      function setInvalid(message) {
        event.preventDefault();
        fileInput.classList.add('is-invalid');
        fileInput.setCustomValidity(message);
        feedback.textContent = message;
      }
    }

    function copyToClipboard(element, thisElement) {
      const input = $(element);
      if (!input.length) return;

      input.select();
      document.execCommand('copy');

      $(thisElement).html('<i class="fas fa-check fa-fw"></i>');
      setTimeout(() => {
        $(thisElement).html('<i class="fas fa-copy fa-fw"></i>');
      }, 1000);
    }
  </script>
</body>

</html>