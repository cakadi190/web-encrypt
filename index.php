<!DOCTYPE html>
<html lang="id-ID">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Encrypt Your File!</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container py-5 min-vh-100">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-img-top" style="height: 200px;">
            <img class="w-100 h-100 object-fit-cover" src="assets/images/compressed.jpg" alt="Cover">
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
                <h1 class="h5">Panduan Penggunaan</h1>
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
              <h2 class="h5">Enkripsi</h2>
              <p>Silahkan unggah berkas yang sesuai dengan format untuk dienkripsikan.</p>

              <form action="./process.php" id="post-encrypt" enctype="multipart/form-data" method="POST"
                class="needs-validation" novalidate>
                <div class="form-group mb-3">
                  <label for="file" class="form-label">Pilih berkas</label>
                  <input type="file" name="file" id="file" data-max-size="1048576" class="form-control" accept="image/*"
                    required>
                  <div class="invalid-feedback">Harap isi dengan data yang benar.</div>
                </div>
                <button class="btn btn-primary" type="submit">Enkripsi</button>
              </form>
            </div>
            <div class="tab-pane fade" id="dekripsi">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

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
            validateFile(event, form);
          }
          form.classList.add('was-validated');
        });
      });
    });

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
  </script>
</body>

</html>