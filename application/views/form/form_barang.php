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
              <?php $url = ($action == 'edit' ? 'barang/actionUpdate/app_barang/'.$dtlBarang->kode_barang : 'barang/actionAdd/app_barang') ?>
              <form action="<?//= base_url($url); ?>" method="post">
                <div class="form-group">
                  <label>Kode Barang</label>
                  <input type="text" class="form-control" value="KW772" disabled value="<?= $action == 'edit' ? $dtlBarang->nama_barang : '' ?>"  name="kode_barang" <?= $action == 'edit' ? 'disabled' : '' ?> required>
                </div>

                <div class="form-group">
                  <label>Nama Barang</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? $dtlBarang->kode_barang : '' ?>" name="nama_barang" <?= $action == 'edit' ? 'disabled' : '' ?>  required>
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