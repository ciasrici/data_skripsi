<?php
require 'templates/header.php';
require 'config/get_connection.php';

$query_kamar = mysqli_query(connect(), "SELECT * FROM kamar ORDER BY id_kamar DESC LIMIT 4");

?>

<!-- Page Content -->
<div class="container">
  <!-- Page Features -->
  <div class="row text-center my-4">

    <?php while ($row = mysqli_fetch_assoc($query_kamar)) : ?>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <?php if($row['gambar']) : ?>
            <img class="card-img-top" src="administrator/assets/images/kamar/<?= $row['gambar']; ?>" alt="">
          <?php else : ?>
            <img class="card-img-top" src="administrator/assets/images/kamar/default.png" alt="">
          <?php endif; ?>
          <div class="card-body">
            <h4 class="card-title"><?= $row['nama_kamar']; ?></h4>
            <p class="card-text"><?= substr($row['fasilitas'], 0, 100); ?></p>
          </div>
          <div class="card-footer">
            <a href="detail.php?kamar=<?= $row['id_kamar']; ?>" class="btn btn-primary">Detail</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->

<?php require 'templates/footer.html'; ?>