<?php
// session_start();
require_once '../pembayaran/function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";
?>
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Laporan</h2>
                </div>
            </div>
        </div>
        <?php if (isset($_SESSION['success'])) : ?>
            <div class='alert alert-success'>
                <?= $_SESSION['success']; ?>
            </div>
        <?php unset($_SESSION['success']);
        endif; ?>

        <?php if (isset($_SESSION['failed'])) : ?>
            <div class='alert alert-danger'>
                <?= $_SESSION['failed']; ?>
            </div>
        <?php unset($_SESSION['failed']);
        endif; ?>
        <div class='card'>
            <div class='card-header'>
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Dari</label>
                            <input type="date" name="dari" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Sampai</label>
                            <input type="date" name="sampai" class="form-control">
                        </div>
                        <div class="col-lg-4 mt-2">
                            <br>
                            <button type="submit" name="date" class="btn btn-primary btn-sm">Cari</button>
                            <button onclick="printDiv('printThis')" id="btnPrint" class="btn btn-success btn-sm">Cetak</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class='card-body'>
                <h3 id="titleLaporan" style="display: none;">Laporan Pembayaran</h3>
                <div class='table-responsive' id="printThis">
                    <table class='table table-bordered'>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Kamar</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>

                        <?php
                        if (isset($_GET['date'])) {
                            $data = GetByDate();
                        } else {
                            $data = getAll();
                        }
                        $no = ($_GET['page'] > 1) ? ($_GET['page'] * 10) - 9 : 1;
                        ?>

                        <?php if ($data) : ?>

                            <tbody class='fbody'>
                                <?php $total = 0;
                                foreach ($data as $td) :
                                    $total += $td['nominal'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $td['nama']; ?></td>
                                        <td><?= $td['nama_kamar']; ?></td>
                                        <td><?= date('d F Y H:i:s', strtotime($td['tanggal'])); ?></td>
                                        <td class="text-right">Rp <?= number_format($td['nominal']); ?></td>
                                        <td><?= ($td['status'] == 1) ? 'Lunas' : ''; ?></td>
                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                                <tr>
                                    <th colspan="4" class="text-center">Total pembayaran</th>
                                    <td class="text-right"><?= number_format($total); ?></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        <?php else : ?>
                            <td colspan='10' class='text-center'>Tidak ada data</td>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <div class='card-footer'>
                <nav aria-label='Page navigation example'>
                    <ul class='pagination'>
                        <?php for ($i = 1; $i <= pagination()['total_page']; $i++) : ?>
                            <?php if ($i == pagination()['page']) : ?>
                                <li class='page-item active'><a class='page-link' href='?page=<?= $i; ?>'><?= $i; ?></a></li>
                            <?php else : ?>
                                <li class='page-item'><a class='page-link' href='?page=<?= $i; ?>'><?= $i; ?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
    <?php require "../templates/footer.html"; ?>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            var css = '@page { size: potrait; }',
                head = document.head || document.getElementsByTagName('head')[0],
                style = document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet) {
                style.styleSheet.cssText = css;
            } else {
                style.appendChild(document.createTextNode(css));
            }

            head.appendChild(style);
            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>