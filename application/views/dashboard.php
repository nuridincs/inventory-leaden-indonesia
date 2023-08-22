<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <!-- <h1>Buat Permintaan</h1> -->
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      </div>
    </div>

    <div class="section-body">
      <h1 class="mb-5">Selamat Datang di Sistem Informasi Pengontrolan Produksi PT. Yasunli Abadi Utama Plastik Bekasi</h1>

      <div>
        <h4 class="text-center">Data Produksi <?= date("l").", ".date("d-m-Y") ?></h4>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <input type="hidden" id="idSelected">

                  <table class="table table-striped" id="table-1">
                    <thead>
                      <tr>
                        <th class="text-center">Nomor</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Customer</th>
                        <th>Qty</th>
                        <th>Tanggal Planning</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $no = 0;
                      $leadtime = 30;

                      foreach($barang as $data) {
                        $no++;
                    ?>
                      <tr>
                        <td><?= $no; ?></td>
                        <td><?= $data->kode_barang ?></td>
                        <td><?= $data->nama_barang ?></td>
                        <td><?= $data->customer ?></td>
                        <td><?= $data->qty ?></td>
                        <td><?= $data->tgl_planning ?></td>
                        <td><?= date('Y-m-d', strtotime($data->tgl_masuk)) ?></td>
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
    </div>
  </section>
</div>