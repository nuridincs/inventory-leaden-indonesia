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
              <div class="row">
                <div class="col-2">
                  <h5 class="m-0 text-dark mb-2">Laporan</h5>
                  <a href="<?= base_url() ?>barang/cetakLaporan/<?= $type ?>" class="btn btn-danger mb-4">Cetak Laporan</a>
                </div>
                <div class="col-4">
                  <h5 class="m-0 text-dark mb-2">Filter</h5>
                    <form action="<?= base_url('barang/laporan'); ?>" method="post">
                      <div class="row">
                        <div class="col-sm-6">
                          <select class="form-control" name="selectedFilter">
                            <option value="all">Semua</option>
                            <option value="ok">OK</option>
                            <option value="reject">Reject</option>
                          </select>
                        </div>
                        <div class="col-sm-6">
                          <input type="submit" class="btn btn-primary" value="Search"></input>
                        </div>
                      </div>
                    </form>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">Nomor</th>
                      <th>Kode Barang</th>
                      <th>Kode Planning</th>
                      <th>Nama Barang</th>
                      <th>Customer</th>
                      <th>Qty</th>
                      <?php if ($type === "all" || $type === "ok" ) { ?>
                      <th>Qty Ok</th>
                      <?php } ?>
                      <?php if ($type === "all" || $type === "reject") { ?>
                      <th>Qty Reject</th>
                      <?php } ?>
                      <th>Jumlah Sampel</th>
                      <th>Total Produksi</th>
                      <th>Tanggal Planning</th>
                      <th>Tanggal Masuk</th>
                      <th>Tanggal Keluar</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $no = 0;
                    foreach($laporan as $data) {
                      $no++;
                      $jumlah_produksi = $data->qty - $data->qty_reject;
                  ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $data->kode_barang ?></td>
                      <td><?= $data->kode_planning ?></td>
                      <td><?= $data->nama_barang ?></td>
                      <td><?= $data->customer ?></td>
                      <td><?= $data->qty ?></td>
                      <?php if ($type === "all" || $type === "ok" ) { ?>
                      <td><?= $data->qty_ok ?></td>
                      <?php } ?>
                      <?php if ($type === "all" || $type === "reject") { ?>
                      <td><?= $data->qty_reject ?></td>
                      <?php } ?>
                      <td><?= $data->jumlah_sample ?></td>
                      <td><?= $jumlah_produksi ?></td>
                      <td><?= $data->tgl_planning ?></td>
                      <td><?= date("Y-m-d", strtotime($data->tgl_masuk)) ?></td>
                      <td><?= $data->tgl_keluar ?></td>
                      <td><?= $data->status ?></td>
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