<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Barang</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Modules</a></div>
        <div class="breadcrumb-item">DataTables</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- <div class="card-header">
              <h4>Basic DataTables</h4>
            </div> -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">
                        Nomor
                      </th>
                      <th>Part Name</th>
                      <th>Part Number</th>
                      <th>Minimum Stok</th>
                      <th>Bill Of Material</th>
                      <!-- <th>Status</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $no = 0; foreach($barang as $data) { $no++; ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                      </td>
                      <td><?= $data->part_name ?></td>
                      <td class="align-middle">
                        <?= $data->part_number ?>
                      </td>
                      <td>
                        <?= $data->minimum_stok ?>
                      </td>
                      <td><?= $data->bom ?></td>
                      <!-- <td><div class="badge badge-success">Completed</div></td> -->
                      <td><a href="#" class="btn btn-secondary">Detail</a></td>
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