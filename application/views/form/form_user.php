<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
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
              <form action="/actionAdd/createUser" method="post">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" value="<?= $action == 'edit' ? 'admin test' : '' ?>"  name="nama" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" value="<?= $action == 'edit' ? 'admin@gmail.com' : '' ?>" name="email" required>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" value="<?= $action == 'edit' ? '' : '' ?>" name="password">
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