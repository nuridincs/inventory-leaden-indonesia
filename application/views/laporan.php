<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Laporan</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Data</a></div>
        <div class="breadcrumb-item">Laporan</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form id="formData" name="formData" method="post" action="">
                <div class="form-group">
                  <label class="d-block">Date Range</label>
                  <input type="text" class="form-control w-50" name="dateRange" readonly id="filter-date">
                  <br>
                  <a href="javascript:;" class="btn btn-primary daterange-btn icon-left btn-icon"><i class="fas fa-calendar"></i> Pilih Tanggal
                  </a>
                </div>
                <button class="btn btn-danger mb-4" id="cetakLaporan" onClick="generateReport()">Cetak Laporan</button>
                <button class="btn btn-info mb-4" onClick="generateReport(100)">Cetak Tipe 100</button>
                <button class="btn btn-primary mb-4" onClick="generateReport(200)">Cetak Tipe 200 </button>
                <!-- <a href="<?//= base_url() ?>barang/cetakLaporan" class="btn btn-danger mb-4">Cetak Laporan</a>
                <a href="<?//= base_url() ?>barang/cetakLaporan/100" class="btn btn-info mb-4">Cetak Tipe 100</a>
                <a href="<?//= base_url() ?>barang/cetakLaporan/200" class="btn btn-primary mb-4">Cetak Tipe 200 </a> -->
              </form>
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">Nomor</th>
                      <th>Part Name</th>
                      <th>Part Number</th>
                      <th>Jumlah Barang Masuk</th>
                      <th>Jumlah Barang Keluar</th>
                      <th>Tanggal Masuk</th>
                      <th>Tanggal Keluar</th>
                      <th>Sisa Barang</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $no = 0;
                    foreach($laporan as $data) {
                      $no++;
                      $jumlah_barang_masuk = $data->sisa_barang + $data->jumlah_barang_keluar;
                      if ($jumlah_barang_masuk > 0) {
                  ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                      </td>
                      <td><?= $data->part_name ?></td>
                      <td><?= $data->part_number ?></td>
                      <td><?= $jumlah_barang_masuk?></td>
                      <td><?= $data->jumlah_barang_keluar ?></td>
                      <td><?= date('d-m-Y', strtotime($data->tanggal_masuk)) ?></td>
                      <td><?= $data->tanggal_keluar ? date('d-m-Y', strtotime($data->tanggal_keluar)) : ''  ?></td>
                      <td><?= $data->sisa_barang ?></td>
                    </tr>
                  <?php
                    }
                  } ?>
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
  // $( ".cetakLaporan" ).click(function() {
  //   changeActionAndSubmit('/barang/cetakLaporan');
  //   // $.get('<?//= base_url('barang/cetakLaporan'); ?>', [], function( data ) {
  //   //   // window.location.reload();
  //   // });
  // });

  function changeActionAndSubmit(action) {
    document.getElementById('formData').action = action;
    document.getElementById('formData').submit();
  }

  function generateReport(type = null) {
    if (type) {
      changeActionAndSubmit('/barang/cetakLaporan/'+type);
    } else {
      changeActionAndSubmit('/barang/cetakLaporan');
    }
  }
</script>
