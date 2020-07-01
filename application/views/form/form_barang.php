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
              <form action="/actionAdd/buatPermintaan" method="post">
                <div class="form-group">
                  <label>Part Name</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? 'test' : '' ?>"  name="part_name" required>
                </div>
                <div class="form-group">
                  <label>Part Number</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? 'Y234234' : '' ?>" name="part_number" required>
                </div>
                <div class="form-group">
                  <label>Minimum Stok</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? '20' : '' ?>" name="minimum_stok">
                </div>
                <div class="form-group">
                  <label>Bill Of Material</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? '1 unit' : '' ?>" name="bom">
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