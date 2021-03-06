<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Laporan</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Data</a></div>
        <div class="breadcrumb-item">Laporan</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <a href="<?= base_url() ?>barang/cetakLaporan" class="btn btn-danger mb-4">Cetak Laporan</a>
              <a href="<?= base_url() ?>barang/cetakLaporan/100" class="btn btn-info mb-4">Cetak Tipe 100</a>
              <a href="<?= base_url() ?>barang/cetakLaporan/200" class="btn btn-primary mb-4">Cetak Tipe 200 </a>
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">Nomor</th>
                      <th>Part Number</th>
                      <th>Part Name</th>
                      <th>Jumlah Barang Keluar</th>
                      <th>Tanggal Masuk</th>
                      <th>Tanggal Keluar</th>
                      <th>Sisa Barang</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $no = 0;
                    foreach($laporan as $data) {
                      $no++;
                  ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                      </td>
                      <td><?= $data->part_number ?></td>
                      <td><?= $data->part_name ?></td>
                      <td class="align-middle">
                        <?= $data->jumlah_barang_keluar ?>
                      </td>
                      <td><?= $data->tanggal_masuk ?></td>
                      <td><?= $data->tanggal_keluar ?></td>
                      <td><?= $data->sisa_barang ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $this->load->view('_partials/footer'); ?>