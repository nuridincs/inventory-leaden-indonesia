<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Form <?= $action ?> Barang</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Form</a></div>
        <div class="breadcrumb-item">Barang</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <?php $url = ($action == 'edit' ? 'barang/actionUpdate/app_barang/'.$dtlBarang->part_number : 'barang/actionAdd/app_barang') ?>
              <form action="<?= base_url($url); ?>" method="post">
                <div class="form-group">
                  <label>Part Name</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? $dtlBarang->part_name : '' ?>"  name="part_name" <?= $action == 'edit' ? 'disabled' : '' ?> required>
                </div>

                <div class="form-group">
                  <label>Part Number</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? $dtlBarang->part_number : '' ?>" name="part_number" <?= $action == 'edit' ? 'disabled' : '' ?>  required>
                </div>

                <div class="form-group">
                  <label>Minimum Stok</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? $dtlBarang->minimum_stok : '' ?>" name="minimum_stok" required>
                </div>

                <div class="form-group">
                  <label>Bill Of Material</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? $dtlBarang->bom : '' ?>" name="bom" required>
                </div>

                <div class="form-group">
                  <label>Kebutuhan Bahan</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? $dtlBarang->kebutuhan_bahan : '' ?>" name="kebutuhan_bahan" required>
                </div>

                <div class="form-group">
                  <label>Harga</label>
                  <input type="number" class="form-control" value="<?= $action == 'edit' ? $dtlBarang->harga : '' ?>" name="harga" required>
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