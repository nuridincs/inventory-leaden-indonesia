<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $action ?> Permintaan</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Form</a></div>
        <div class="breadcrumb-item">Buat Permintan</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <?php $url = ($action == 'edit' ? 'barang/actionUpdate/app_barang_masuk/'.$dtlBarang->part_number : 'barang/actionAdd/app_barang_masuk') ?>
              <form action="<?= base_url($url); ?>" method="post">
                <?php if (isset($dtlBarang->status_barang) && $dtlBarang->status_barang == 0): ?>
                  <input type="hidden" class="form-control invoice-input" value="<?= $action == 'edit' ? $dtlBarang->status_barang : '' ?>" name="status_barang">
                <?php endif; ?>

                <div class="form-group">
                  <label>Part Number</label>
                  <?php if ($action == 'edit') { ?>
                    <input type="text" class="form-control invoice-input" <?= $action == 'edit' ? 'disabled' : '' ?> value="<?= $action == 'edit' ? $dtlBarang->part_number : '' ?>" name="part_number">
                  <?php } else { ?>
                    <select class="form-control" name="part_number">
                      <?php foreach($barang as $data) { ?>
                        <option value="<?= $data->part_number ?>"><?= $data->part_name.' - '.$data->part_number ?></option>
                      <?php } ?>
                    </select>
                  <?php } ?>
                </div>

                <div class="form-group">
                  <label>Type</label>

                  <select class="form-control" name="id_type">
                  <?php
                    foreach($type as $data) {
                      if ($dtlBarang->id_type == $data->jenis_type) {
                        echo '<option value="'.$data->jenis_type.'" selected>'.$data->jenis_type.'</option>';
                      } else {
                        echo '<option value="'.$data->jenis_type.'">'.$data->jenis_type.'</option>';
                      }
                    }
                  ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Jumlah Barang</label>
                  <input type="text" class="form-control invoice-input" value="<?= $action == 'edit' ? $dtlBarang->jumlah_barang : '' ?>" name="jumlah_barang">
                </div>

                <button class="btn btn-primary btn-block">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>