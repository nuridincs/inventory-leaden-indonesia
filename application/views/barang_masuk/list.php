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
            <div class="card-body">
              <div class="table-responsive">
                <input type="hidden" id="idSelected">

                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">
                        Nomor
                      </th>
                      <th>Part Name</th>
                      <th>Part Number</th>
                      <th>Jenis Type</th>
                      <th>ROP</th>
                      <th>Jumlah Barang</th>
                      <th>Ket.</th>
                      <th>Status Barang</th>
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
                      $status_barang = '<div class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i> Tidak Tersedia</div>';
                      $limit = '';

                      if ($data->status_barang == 1) {
                        $status_barang = '<div class="badge badge-success"><i class="fa fa-check"></i> Tersedia</div>';
                      }

                      if ($data->status_barang == 2) {
                        $status_barang = '<div class="badge badge-warning"><i class="fa fa-clock"></i> Pending</div>';
                      }

                      if ($data->status_barang == 3) {
                        $status_barang = '<div class="badge badge-primary"><i class="fa fa-spinner"></i>  Sedang di Proses</div>';
                      }

                      if ($rop > $data->jumlah_barang) {
                        $limit = '<span class="badge badge-danger">melebihi batas ROP</span>';
                      }
                  ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                      </td>
                      <td><?= $data->part_name ?></td>
                      <td><?= $data->part_number ?></td>
                      <td class="align-middle">
                        <?= $data->id_type ?>
                      </td>
                      <td><?= $rop ?></td>
                      <td>
                        <?= $data->jumlah_barang.' '.$limit ?>
                      </td>
                      <td><?= $data->keterangan ?></td>
                      <td><?= $status_barang ?></td>
                      <td>
                        <?php if($data->status_barang == 2) { ?>
                          <button class="btn btn-icon btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Approve Barang" data-confirm="Apa Anda yakin ingin approve data ini?" data-confirm-yes="approveData(<?= $data->part_number ?>);"><i class="fas fa-check"></i></button>
                        <?php } ?>

                        <?php if($data->status_barang == 3) { ?>
                          <button class="btn btn-icon btn-success" data-toggle="modal" data-target="#modalVerifikasiBarang" onClick="getID(<?= $data->part_number ?>)"><i class="fas fa-check-circle"></i></button>
                        <?php } ?>

                        <?php if($data->status_barang != 0) { ?>
                          <a href="form/form_permintaan/edit/<?= $data->part_number ?>" class="btn btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title data-original-title="Edit Barang"><i class="far fa-edit"></i></a>
                        <?php } ?>

                        <?php if($data->status_barang == 0) { ?>
                          <a href="form/form_permintaan/edit/<?= $data->part_number ?>" class="btn btn-icon btn-info" data-toggle="tooltip" data-placement="top" title data-original-title="Buat Permintaan"><i class="fa fa-reply-all" aria-hidden="true"></i></a>
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
              <textarea id="keterangan" class="form-control" placeholder="Masukan Keterangan"></textarea>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="submitVerifikasiBarang">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $this->load->view('_partials/footer'); ?>

<script>
  function approveData(id) {
    const formData = {
      id: id,
      idName: 'part_number',
      table: 'app_barang_masuk',
      data: {
        status_permintaan: 'sedang_diproses',
        status_barang: 3,
      }
    }

    $.post('<?= base_url('barang/updateStatus'); ?>', formData, function( data ) {
      window.location.reload();
    });
  }

  $('#submitVerifikasiBarang').click(function() {
    const formData = {
      id: $('#idSelected').val(),
      idName: 'part_number',
      table: 'app_barang_masuk',
      data: {
        status_barang: 1,
        keterangan: $('#keterangan').val(),
        status_permintaan: 'tersedia',
      }
    }

    $.post('<?= base_url('barang/updateStatus'); ?>', formData, function( data ) {
      window.location.reload();
    });
  });

  function getID(id) {
    $('#idSelected').val(id);
  }
</script>

<style scoped>
.modal-backdrop {
  z-index: -1;
  background: white;
}
</style>