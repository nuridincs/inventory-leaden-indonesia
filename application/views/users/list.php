<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data User</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Data</a></div>
        <div class="breadcrumb-item">Users</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <a href="form/form_user/tambah/0" class="btn btn-primary mb-4">Buat User</a>
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">
                        Nomor
                      </th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $no = 0;
                    foreach($user as $data) {
                      $no++;
                  ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                      </td>
                      <td><?= $data->nama ?></td>
                      <td class="align-middle">
                        <?= $data->email ?>
                      </td>
                      <td><?= $data->role ?></td>
                      <td>
                        <a href="form/form_user/edit/<?= $data->id ?>" class="btn btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title data-original-title="Edit User"><i class="far fa-edit"></i></a>
                        <button class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Hapus Barang" data-confirm="Apa Anda yakin ingin menghapus data ini?" data-confirm-yes="deleteData(<?= $data->id ?>);;"><i class="fas fa-trash"></i></button>
                      </td>
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

<script>
  function deleteData(id) {
    const formData = {
      id: id,
      idName: 'id',
      table: 'app_users'
    }

    $.post('<?= base_url('barang/actionDelete'); ?>', formData, function( data ) {
      window.location.reload();
    });
  }
</script>