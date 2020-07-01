<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Barang Masuk</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Modules</a></div>
        <div class="breadcrumb-item">DataTables</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- <div class="card-header">
              <h4>Basic DataTables</h4>
            </div> -->
            <div class="card-body">
              <a href="form/form_permintaan" class="btn btn-primary mb-4">Buat Permintaan</a>
              <a href="form/form_siapkan_barang" class="btn btn-info mb-4">Siapkan Barang</a>
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
                      <th>Status Barang</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $no = 0;
                    foreach($barang as $data) {
                      $no++;
                      $status_barang = '<div class="badge badge-danger">Tidak Tersedia</div>';

                      if ($data->status_barang == 1) {
                        $status_barang = '<div class="badge badge-success">Tersedia</div>';
                      }
                  ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                      </td>
                      <td><?= $data->part_number ?></td>
                      <td class="align-middle">
                        <?= $data->id_type ?>
                      </td>
                      <td>
                        <?= $data->jumlah_barang ?>
                      </td>
                      <!-- <td><?//= $data->status_barang ?></td> -->
                      <td><?= $status_barang ?></td>
                      <td><a href="#" class="btn btn-secondary">Detail</a></td>
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