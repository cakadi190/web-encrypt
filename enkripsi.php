<!doctype html>
<html lang="en">

<head>
  <title>Enkripsi</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- BLOG BUGABAGI -->
  <!-- Style -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- JS -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
          <li><a href="#enkripsi">ENKRIPSI</a></li>
          <li><a href="dekripsi.php">DEKRIPSI</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid bg-cover" id="enkripsi" style="margin-top:0px;">
    <div class="page-header">
      <h3><b>ENKRIPSI GAMBAR</b></h3>
    </div>
    <div class="col-md-4">
      <form method="post" enctype="multipart/form-data">
        <label>Masukan Gambar :</label>
        <div class="form">
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
            <input id="upload" type="file" accept="image/*" class="form-control" name="gambar">
          </div><br>
          <button class="btn btn-primary btn-lg" type="submit" id="submit" name="submit">Enkripsi <span class="glyphicon glyphicon-lock" aria-hidden="true"></span></button><br><br>
        </div>
      </form>
    </div>
    <div class="col-md-8">
      <h4>Hasil Enkripsi</h4>

      <?php
      include './proses.php';

      $valid_array = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp');
      if (isset($_POST['submit']) && $_FILES['gambar']['size'] > 0) {

        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $valid_array)) {
          $enkripsi = enkripsi(file_get_contents($_FILES['gambar']['tmp_name']));
          file_put_contents('tmp/Encrypt.txt', $enkripsi);
      ?>

          <form method="post" action="getTxt.php" enctype="multipart/form-data">
            <textarea name="txt" class="form-control" rows="8" id="comment"><?php echo $enkripsi; ?></textarea>
            <br>
            <label>IV: </label><br>
            <input type="text" class="form-control" style="width: 50%;" value="<?= bin2hex($iv) ?>" readonly>
            <br>
            <button type="submit" class="btn btn-success" href="gettxt.php">Unduh Hasil Enkripsi</button>
          </form>

      <?php
        } else {

          echo "<br><div class='alert alert-danger'><strong>Maaf... file yang ada pilih bukan file gambar. Hanya file JPG, PNG, GIF, BMP atau PSD yang boleh diupload..!</strong></div>";
        }
      } ?>


    </div>
  </div>

  <!-- JavaScript -->
  <script>
    $(document).ready(function() {
      // Add smooth scrolling to all links in navbar + footer link
      $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {

          // Prevent default anchor click behavior
          event.preventDefault();

          // Store hash
          var hash = this.hash;

          // Using jQuery's animate() method to add smooth page scroll
          // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 900, function() {

            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          });
        } // End if 
      });
    });
  </script>
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>

</html>
