<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Barang Keluar</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Master</a></div>
        <div class="breadcrumb-item"><a href="#">Barang</a></div>
        <div class="breadcrumb-item">Keluar</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <a href="form/form_siapkan_barang/siapkan" class="btn btn-info mb-4">Siapkan Barang</a>
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">
                        Nomor
                      </th>
                      <th>Part Number</th>
                      <th>Jenis Type</th>
                      <th>Jumlah Barang</th>
                      <th>Tanggal Masuk</th>
                      <th>Tanggal Keluar</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $no = 0;
                    foreach($barang as $data) {
                      $no++;
                  ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                      </td>
                      <td><?= $data->part_number ?></td>
                      <td class="align-middle">
                        <?= $data->id_type ?>
                      </td>
                      <td><?= $data->jumlah_barang ?></td>
                      <td><?= date('Y-m-d', strtotime($data->tanggal_masuk)) ?></td>
                      <td><?= $data->tanggal_keluar ?></td>
                      <td>
                        <a href="cetakInvoice/<?= $data->part_number ?>" class="btn btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title data-original-title="Cetak Invoice"><i class="fas fa-print"></i></a>
                      </td>
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