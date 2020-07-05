<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
$data = $dtlBarang;
?>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Form <?= $action ?> User</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Form</a></div>
        <div class="breadcrumb-item">User</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <?php $url = ($action == 'edit' ? 'barang/actionUpdate/app_users/'.$data->id : 'barang/actionAdd/app_users') ?>
              <form action="<?= base_url($url) ?>" method="post">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? $data->nama : '' ?>"  name="nama" required>
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" value="<?= $action == 'edit' ? $data->email : '' ?>" name="email" required>
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" value="<?= $action == 'edit' ? '' : '' ?>" name="password">
                </div>

                <div class="form-group">
                  <label>Role</label>
                  <select class="form-control" name="role" id="role">
                    <?php
                      foreach ($role as $value) {
                        if ($data->role == $value->kategori) {
                          echo '<option value="'.$value->kategori.'" selected>'.$value->kategori.'</option>';
                        } else {
                          echo '<option value="'.$value->kategori.'">'.$value->kategori.'</option>';
                        }
                      }
                    ?>
                  </select>
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