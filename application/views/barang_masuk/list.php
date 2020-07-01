<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Barang Masuk</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Master</a></div>
        <div class="breadcrumb-item"><a href="#">Barang</a></div>
        <div class="breadcrumb-item">Masuk</div>
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
              <a href="form/form_permintaan/tambah" class="btn btn-primary mb-4">Buat Permintaan</a>
              <!-- <a href="form/form_siapkan_barang" class="btn btn-info mb-4">Siapkan Barang</a> -->
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">
                        Nomor
                      </th>
                      <th>Part Number</th>
                      <th>Jenis Type</th>
                      <th>Jumlah Barang</th>
                      <th>Status Barang</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $no = 0;
                    foreach($barang as $data) {
                      $no++;
                      $status_barang = '<div class="badge badge-danger">Tidak Tersedia</div>';

                      if ($data->status_barang == 1) {
                        $status_barang = '<div class="badge badge-success">Tersedia</div>';
                      }

                      if ($data->status_barang == 2) {
                        $status_barang = '<div class="badge badge-warning">Pending</div>';
                      }

                      if ($data->status_barang == 3) {
                        $status_barang = '<div class="badge badge-primary">Sedang di Proses</div>';
                      }
                  ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                      </td>
                      <td><?= $data->part_number ?></td>
                      <td class="align-middle">
                        <?= $data->id_type ?>
                      </td>
                      <td>
                        <?= $data->jumlah_barang ?>
                      </td>
                      <td><?= $status_barang ?></td>
                      <td>
                        <?php if($data->status_barang == 2) { ?>
                          <a href="form/form_permintaan/edit" class="btn btn-icon btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Approve"><i class="fas fa-check"></i></a>
                        <?php } ?>

                        <?php if($data->status_barang == 3) { ?>
                          <button class="btn btn-icon btn-success" data-toggle="modal" data-target="#modalVerifikasiBarang"><i class="fas fa-check-circle"></i></button>
                        <?php } ?>

                        <?php if($data->status_barang != 0) { ?>
                          <a href="form/form_permintaan/edit" class="btn btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title data-original-title="Edit Barang"><i class="far fa-edit"></i></a>
                        <?php } ?>
                        <button class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Hapus Barang" data-confirm="Apa Anda yakin ingin menghapus data ini?" data-confirm-yes="alert('Deleted :)');"><i class="fas fa-trash"></i></button>
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

    <div class="modal" id="modalVerifikasiBarang">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Apakah barang sudah sesuai ?</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" class="form-control" placeholder="Masukan Keterangan"></textarea>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="submitverifikasibarang">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $this->load->view('_partials/footer'); ?>

<style scoped>
.modal-backdrop {
  z-index: -1;
  background: white;
}
</style>