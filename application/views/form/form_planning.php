<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $action ?> perencanaan</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Form</a></div>
        <div class="breadcrumb-item">Buat perencanaan</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <?php $url = ($action == 'edit' ? 'barang/actionUpdate/app_barangs/'.$dtlBarang->id : 'barang/actionAdd/app_barangs') ?>
              <form action="<?= base_url($url); ?>" method="post">
                <?php if (isset($dtlBarang->status_barang) && $dtlBarang->status_barang == 0): ?>
                  <input type="hidden" class="form-control invoice-input" value="<?= $action == 'edit' ? $dtlBarang->status_barang : '' ?>" name="status_barang">
                <?php endif; ?>

                <div class="form-group">
                  <label>Kode Barang</label>
                  <?php if ($action == 'edit') { ?>
                    <input type="text" class="form-control invoice-input" <?= $action == 'edit' ? 'disabled' : '' ?> value="<?= $action == 'edit' ? $dtlBarang->part_number : '' ?>" name="part_number">
                  <?php } else { ?>
                    <select class="form-control" name="kode_barang">
                      <?php foreach($barang as $data) { ?>
                        <option value="<?= $data->kode_barang ?>"><?= $data->kode_barang.' - '.$data->nama_barang ?></option>
                      <?php } ?>
                    </select>
                  <?php } ?>
                </div>

                <div class="form-group">
                  <label>Customer</label>
                  <input type="text" class="form-control invoice-input" value="<?= $action == 'edit' ? $dtlBarang->customer : '' ?>" name="customer">
                </div>


                <div class="form-group">
                  <label>Qty</label>
                  <input type="number" class="form-control invoice-input" value="<?= $action == 'edit' ? $dtlBarang->qty : '' ?>" name="qty">
                </div>

                <div class="form-group">
                  <label>Tanggal Planning</label>
                  <input type="date" class="form-control invoice-input" value="<?= $action == 'edit' ? $dtlBarang->tgl_planning : '' ?>" name="tgl_planning">
                </div>

                <input type="hidden" name="status" value="proses-produksi">

                <button class="btn btn-primary btn-block">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>