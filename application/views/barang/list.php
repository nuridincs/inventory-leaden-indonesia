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
        <div class="breadcrumb-item active"><a href="#">Master</a></div>
        <div class="breadcrumb-item">Barang</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <a href="form/form_barang/tambah/0" class="btn btn-icon btn-info mb-4">Tambah Barang</a>
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
                      <th>ROP</th>
                      <th>Stok</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $no = 0;
                    $leadtime = 30;
                    foreach($barang as $data) {
                      $no++;

                      $rop = $leadtime * $data->kebutuhan_bahan + $data->minimum_stok;
                      $stok = $data->stok;

                      if ($data->stok == NULL) {
                        $stok = 0;
                      }
                  ?>
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
                      <td><?= $rop ?></td>
                      <td><?= $stok ?></td>
                      <td>
                        <a href="form/form_barang/edit/<?= $data->part_number ?>" class="btn btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title data-original-title="Edit Barang"><i class="far fa-edit"></i></a>
                        <button class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Hapus Barang" data-confirm="Apa Anda yakin ingin menghapus data ini?" data-confirm-yes="deleteData('<?= $data->part_number ?>');"><i class="fas fa-trash"></i></button>
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
      idName: 'part_number',
      table: 'app_barang'
    }

    $.post('<?= base_url('barang/actionDelete'); ?>', formData, function( data ) {
      window.location.reload();
    });
  }
</script>