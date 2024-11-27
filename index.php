<!DOCTYPE html>
<html lang="id-ID">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bootstrap 101 Template</title>

  <!-- Bootstrap -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
  <div class="container py-5 min-vh-100">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="card">
          <div class="card-header bg-white border-light">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" id="panduan-tab" data-bs-toggle="tab" href="#panduan"
                  aria-current="true">Panduan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="enkripsi-tab" data-bs-toggle="tab" href="#enkripsi">Enkripsi</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="dekripsi-tab" data-bs-toggle="tab" href="#dekripsi">Dekripsi</a>
              </li>
            </ul>
          </div>
          <div class="card-body tab-content">
            <div class="tab-pane fade show active" id="panduan">
            </div>
            <div class="tab-pane fade" id="enkripsi">
            </div>
            <div class="tab-pane fade" id="dekripsi">
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.min.js"></script>
</body>