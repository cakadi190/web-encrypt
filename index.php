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
                <button onclick="resetAllForms()" class="nav-link active" data-bs-toggle="tab" data-bs-target="#panduan">Panduan</button>
              </li>
              <li class="nav-item">
                <button onclick="resetAllForms()" class="nav-link" data-bs-toggle="tab" data-bs-target="#enkripsi">Enkripsi</button>
              </li>
              <li class="nav-item">
                <button onclick="resetAllForms()" class="nav-link" data-bs-toggle="tab" data-bs-target="#dekripsi">Dekripsi</button>
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
                    <input type="text" name="iv" id="iv" class="form-control" required placeholder="Kunci Enkripsi Berformat Base64" />
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

                <div class="collapse text-center" id="resultDecrypted">
                  <h3 class="h6 mt-3">Hasil Dekripsi</h3>
                  <div class="form-group">
                    <img id="img-result" class="border d-block mx-auto mb-2" src="" alt="Hasil Dekripsi" style="max-width: 100%;" />
                    <button id="download-file" data-base64="" class="btn btn-primary">Unduh Berkas</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <p class="mb-0 text-center pt-4">Created By <a href="https://www.cakadi.web.id">Amir Zuhdi Wibowo</a>, Muhammad Dimas Mulyono, Rinda Kusuma Dewi.</p>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/main.js"></script>
</body>

</html>