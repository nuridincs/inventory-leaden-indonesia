<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Siapkan Barang</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Form</a></div>
        <div class="breadcrumb-item">Siapkan Barang</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form action="/actionAdd/buatPermintaan" method="post">
                <div class="form-group">
                  <label>Part Name / Part Number</label>
                  <select class="form-control" name="part_number">
                  <?php foreach($barang as $data) { ?>
                    <option value="<?= $data->part_number ?>"><?= $data->part_name.' - '.$data->part_number ?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Type</label>
                  <select class="form-control" name="type">
                  <?php foreach($type as $data) { ?>
                    <option value="<?= $data->id ?>"><?= $data->jenis_type ?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Jumlah Barang</label>
                  <input type="text" class="form-control invoice-input" value="<?= $action == 'edit' ? '200' : '' ?>">
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