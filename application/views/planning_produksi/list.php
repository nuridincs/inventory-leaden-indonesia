<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Perencanaan</h1>
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
              <?php if ($role !== 'qc') { ?>
                <a href="form/form_planning/tambah/0" class="btn btn-primary mb-4">Buat Perencanaan</a>
              <?php } ?>
                <div class="table-responsive">
                <input type="hidden" id="idSelected">

                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">Nomor</th>
                      <th>Kode Barang</th>
                      <th>Kode Planning</th>
                      <th>Nama Barang</th>
                      <th>Customer</th>
                      <th>Qty</th>
                      <th>Qty Ok</th>
                      <th>Qty Reject</th>
                      <th>Keterangan</th>
                      <th>Tanggal Planning</th>
                      <th>Tanggal Masuk</th>
                      <th>Tanggal Keluar</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $no = 0;
                    $leadtime = 30;
                    foreach($barang as $data) {
                      $no++;
                      $latestStatus = $data->status;
                      if ($data->status === 'proses-sampel-qc' && $data->jumlah_sample) {
                        $latestStatus = 'proses-qc';
                      }
                  ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $data->kode_barang ?></td>
                      <td><?= $data->kode_planning ?></td>
                      <td><?= $data->nama_barang ?></td>
                      <td><?= $data->customer ?></td>
                      <td><?= $data->qty ?></td>
                      <td><?= $data->qty_ok ?></td>
                      <td><?= $data->qty_reject ?></td>
                      <td><?= $data->keterangan ?></td>
                      <td><?= $data->tgl_planning ?></td>
                      <td><?= date('Y-m-d', strtotime($data->tgl_masuk)) ?></td>
                      <td><?= $data->tgl_keluar ?></td>
                      <td><?= $latestStatus ?></td>
                      <td>
                        <?php if($this->session->userdata['role'] === 'qc' && in_array($data->status, ['proses-qc', 'proses-sampel-qc'])) { ?>
                          <button class="btn btn-icon btn-primary" data-toggle="modal" data-target="#modalAddInspector" onClick="getID(<?= $data->id ?>)"><i class="far fa-edit"></i></button>
                        <?php } ?>

                        <?php
                          $role = ['ppic', 'admin'];
                          if (in_array($this->session->userdata['role'], $role)) {
                        ?>
                          <button class="btn btn-icon btn-info" data-toggle="tooltip" data-placement="top" title data-original-title="Update Status Produksi" data-confirm="Apa Anda yakin ingin menyelesaikan produksi ini?" data-confirm-yes="updateStatus('<?= $data->id ?>');"><i class="fas fa-check-circle"></i></button>
                          <button class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Hapus Barang" data-confirm="Apa Anda yakin ingin menghapus data ini?" data-confirm-yes="deleteData('<?= $data->id ?>');"><i class="fas fa-trash"></i></button>
                          <button class="btn btn-icon btn-primary" data-toggle="modal" data-target="#modalAddInspector" onClick="getID(<?= $data->id ?>)"><i class="far fa-edit"></i></button>
                        <?php } ?>

                        <?php if($this->session->userdata['role'] === 'qc' && $data->status === 'selesai') { ?>
                        <?php } else { ?>
                          <?php if(!$data->jumlah_sample) { ?>
                          <button class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Update Status Data Sampel" data-confirm="Apakah Anda yakin ingin memproses data sampel ini?" data-confirm-yes="updateStatus('<?= $data->id ?>', 'data-sample');"><i class="fas fa-check-circle"></i></button>
                          <?php } ?>
                        <?php } ?>
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

    <div class="modal" id="modalAddComment">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Tambahkan Komentar</h4>
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
            <button type="submit" class="btn btn-primary" id="submitAddComment">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="modalAddInspector">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Inspektor Cek</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="form-group">
              <label for="qty_ok">Barang OK</label>
              <input id="qty_ok" class="form-control" placeholder="Masukan Qty Ok"/>
            </div>
            <div class="form-group">
              <label for="qty_reject">Barang Reject</label>
              <input id="qty_reject" class="form-control" placeholder="Masukan Qty Reject"/>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="submitInspectorCek">Submit</button>
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
      idName: 'id',
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

  $('#submitAddComment').click(function() {
    const formData = {
      id: $('#idSelected').val(),
      idName: 'id',
      table: 'app_barangs',
      data: {
        keterangan: $('#keterangan').val(),
      }
    }

    $.post('<?= base_url('barang/updateStatus'); ?>', formData, function( data ) {
      window.location.reload();
    });
  });

  $('#submitInspectorCek').click(function() {
    const currentdate = new Date();

    const formData = {
      id: $('#idSelected').val(),
      idName: 'id',
      table: 'app_barangs',
      data: {
        qty_ok: $('#qty_ok').val(),
        qty_reject: $('#qty_reject').val(),
        status: 'selesai',
        tgl_keluar: new Date(currentdate.getTime() - (currentdate.getTimezoneOffset() * 60000)).toISOString().split(".")[0].replace(/[T:]/g, '-')
      }
    }
    console.log("formData:", formData);

    $.post('<?= base_url('barang/updateStatus'); ?>', formData, function( data ) {
      window.location.reload();
    });
  });

  function getID(id) {
    $('#idSelected').val(id);
  }

  function updateStatus(id, type = null) {
    let status = 'proses-qc';

    if (type === 'data-sample') {
      status = 'proses-sampel-qc'
    }

    const formData = {
      id,
      idName: 'id',
      table: 'app_barangs',
      data: {
        status
      }
    }

    $.post('<?= base_url('barang/updateStatus'); ?>', formData, function( data ) {
      window.location.reload();
    });
  }

  function deleteData(id) {
    const formData = {
      id: id,
      idName: 'id',
      table: 'app_barangs'
    }

    $.post('<?= base_url('barang/actionDelete'); ?>', formData, function( data ) {
      window.location.reload();
    });
  }
</script>

<style scoped>
.modal-backdrop {
  z-index: -1;
  background: white;
}
</style>