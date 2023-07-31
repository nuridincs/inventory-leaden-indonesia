<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Barang Keluar</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Data</a></div>
        <div class="breadcrumb-item"><a href="#">Sampel</a></div>
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
                      <th class="text-center">Nomor</th>
                      <th>Kode Barang</th>
                      <th>Kode Planning</th>
                      <th>Nama Barang</th>
                      <th>Qty</th>
                      <th>Tanggal Planning</th>
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
                  ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $data->kode_barang ?></td>
                      <td><?= $data->kode_planning ?></td>
                      <td><?= $data->nama_barang ?></td>
                      <td><?= $data->qty ?></td>
                      <td><?= $data->tgl_planning ?></td>
                      <td><?= $data->status ?></td>
                      <td>
                          <button class="btn btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title data-original-title="Update Status Barang Diterima" data-confirm="Apakah Anda yakin barang ini sudah diterima?" data-confirm-yes="updateStatus('<?= $data->id ?>');"><i class="fas fa-check-circle"></i></button>
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

    <div class="modal" id="modalAddSample">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Tambahkan Detil Sampel</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="form-group">
              <label for="jumlah_sample">Jumlah Sampel</label>
              <input type="number" id="jumlah_sample" class="form-control" placeholder="Masukan Jumlah Sampel"/>
            </div>

            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea id="keterangan" class="form-control" placeholder="Masukan Keterangan"></textarea>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="submitAddSample">Submit</button>
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

  $('#submitAddSample').click(function() {
    const formData = {
      id: $('#idSelected').val(),
      idName: 'id',
      table: 'app_barangs',
      data: {
        jumlah_sample: $('#jumlah_sample').val(),
        keterangan: $('#keterangan').val(),
      }
    }

    $.post('<?= base_url('barang/updateStatus'); ?>', formData, function( data ) {
      window.location.reload();
    });
  });

  $('#submitInspectorCek').click(function() {
    const formData = {
      id: $('#idSelected').val(),
      idName: 'id',
      table: 'app_barangs',
      data: {
        qty_ok: $('#qty_ok').val(),
        qty_reject: $('#qty_reject').val(),
        status: 'selesai'
      }
    }

    $.post('<?= base_url('barang/updateStatus'); ?>', formData, function( data ) {
      window.location.reload();
    });
  });

  function getID(id) {
    $('#idSelected').val(id);
  }

  function updateStatus(id) {
    let status = 'sudah-diterima';

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