<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Barang extends CI_Controller {
    public function __construct()
    {
      parent::__construct();

      $this->load->model('M_barang', 'barang');
      $this->load->library('Pdf');

      $cekUserLogin = $this->session->userdata('status');

      if ($cekUserLogin != 'login') {
        redirect('login');
      }
    }

    public function index()
    {
      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | Dashboard",
        'barang' => $this->barang->getPlanningList()
      );

      $this->load->view('dashboard', $data);
    }

    public function listMasterBarang()
    {
      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | Master Barang",
        'barang' => $this->barang->getData('app_master_barang')
      );

      $this->load->view('barang/list', $data);
    }

    public function listPlanning()
    {
      $barang = $this->barang->getJoinData('kode_barang', 'app_barangs', 'app_master_barang');

      if ($this->session->userdata('role') === 'qc') {
        $barang = $this->barang->getDataByStatus(array('proses-sampel-qc', 'proses-qc'));
      }

      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | List Planning",
        'barang' => $barang,
        'role' => $this->session->userdata('role')
      );
      $this->load->view('planning_produksi/list', $data);
    }

    public function listDataSample() {
      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | Data Sampel",
        'barang' => $this->barang->getDataByStatus(array('proses-sampel-qc')),
        'role' => $this->session->userdata('role'),
      );

      $this->load->view('data_sample/list', $data);
    }

    public function laporanProduksi() {
      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | Laporan Produksi",
        'barang' => $this->barang->getDataByStatus('proses-qc'),
        'role' => $this->session->userdata('role'),
      );

      $this->load->view('laporan_produksi/list', $data);
    }

    public function listBarangMasuk()
    {
      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | Barang Masuk",
        'barang' => $this->barang->getJoinData('part_number', 'app_barang', 'app_barang_masuk')
      );

      $this->load->view('barang_masuk/list', $data);
    }

    public function listBarangKeluar()
    {
      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | Barang Keluar",
        'barang' => $this->barang->getDataByStatus('selesai'),
        'role' => $this->session->userdata('role'),
      );
      $this->load->view('barang_keluar/list', $data);
    }

    public function listUser()
    {
      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | Data User",
        'user' => $this->barang->getData('app_users')
      );

      $this->load->view('users/list', $data);
    }

    public function laporan()
    {
      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | Laporan",
        'laporan' => $this->barang->getLaporanProduksi()
        // 'barang' => $this->barang->getJoinData('part_number', 'app_barang', 'app_barang_masuk')
      );
      // print_r($data);die;

      $this->load->view('laporan', $data);
    }

    public function form($form, $action, $id)
    {
      $dtlBarang = [];

      $dataLastMasterBarang = $this->barang->getLastKodeBarang();
      $nextSequence = $this->generateNextSequence($dataLastMasterBarang->kode_barang);
      $kodeBarang = $nextSequence;

      $dataLastKodePlanning = $this->barang->getLastKodePlanning();
      $nextSequenceKP = $this->generateNextSequence($dataLastKodePlanning->kode_planning);
      $kodePlanning = $nextSequenceKP;

      if($action == 'edit') {
        $dtlBarang = $this->getDataByAction($form, $id);
        $kodeBarang = $dtlBarang->kode_barang;
        $kodePlanning = $dtlBarang->kode_planning;
      }


      $data = array(
        'title' => "Sistem Informasi Pengontrolan Produksi | Form ". $form,
        'action' => $action,
        'barang' => $this->getData($form, 'app_master_barang'),
        'type' => $this->getData($form, 'app_type'),
        'role' => $this->barang->getData('app_role'),
        'dtlBarang' => $dtlBarang,
        'kode_barang' => $kodeBarang,
        'kodePlanning' => $kodePlanning,
      );

      $this->load->view('form/'.$form, $data);
    }

    private function getDataByAction($form, $id)
    {
      $result = [];
      if($form == 'form_barang') {
        $result = $this->barang->getDataByID('app_master_barang', 'kode_barang', $id);
      }
      // print_r($result);die;

      if($form == 'form_permintaan') {
        $result = $this->barang->getDataByID('app_barang_masuk', 'id', $id);
      }

      if($form == 'form_user') {
        $result = $this->barang->getDataByID('app_users', 'id', $id);
      }

      return $result;
    }

    public function getData($form, $table)
    {
      $result = [];
      if($form == 'form_planning' || $form == 'form_siapkan_barang') {
        $result = $this->barang->getData($table);
      }

      return $result;
    }

    public function cetakLaporan($id_type = null)
    {
      $data = $this->barang->getLaporanProduksi($id_type);

      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      // document informasi
      $pdf->SetCreator('Pengontrolan Produksi');

      $pdf->SetTitle('Laporan');
      $pdf->SetSubject('Laporan');

      //header Data
      // $pdf->SetHeaderData('rubberman-logo.jpg',30,'','',array(203, 58, 44),array(0, 0, 0));
      // $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));

      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      //set margin
      $pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP + 10,PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

      $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

      //SET Scaling ImagickPixel
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      //FONT Subsetting
      $pdf->setFontSubsetting(true);

      $pdf->SetFont('helvetica','',14,'',true);

      $pdf->AddPage('L');

      $html = '<div>';
      if ($id_type != null) {
        $html .= '<h1 align="center">Laporan Barang dengan Tipe '.$id_type.'</h1>';
      } else {
        $html .= '<h1 align="center">Laporan Produksi</h1>';
      }
      $html .='
          <table border="1" width="100" align="center">
            <tr>
              <th style="width:40px" align="center">No</th>
              <th style="width:100px" align="center">Kode Barang</th>
              <th style="width:100px" align="center">Kode Planning</th>
              <th style="width:120px" align="center">Nama Barang</th>
              <th style="width:70px" align="center">Customer</th>
              <th style="width:50px" align="center">Qty</th>
              <th style="width:50px" align="center">Qty Ok</th>
              <th style="width:50px" align="center">Qty Reject</th>
              <th style="width:100px" align="center">Tanggal Planning</th>
              <th style="width:100px" align="center">Tanggal Masuk</th>
              <th style="width:100px" align="center">Tanggal Keluar</th>
              <th style="width:100px" align="center">Status</th>
            </tr>';

            $no = 0;
            foreach($data as $item) {
              $no++;
              $html .= '<tr>
                <td>'.$no.'</td>
                <td>'.$item->kode_barang.'</td>
                <td>'.$item->kode_planning.'</td>
                <td>'.$item->nama_barang.'</td>
                <td>'.$item->customer.'</td>
                <td>'.$item->qty.'</td>
                <td>'.$item->qty_ok.'</td>
                <td>'.$item->qty_reject.'</td>
                <td>'.date('Y-m-d', strtotime($item->tgl_planning)).'</td>
                <td>'.date('Y-m-d', strtotime($item->tgl_masuk)).'</td>
                <td>'.$item->tgl_keluar.'</td>
                <td>'.$item->status.'</td>
              </tr>';
          }

          $html .='
              </table>
              <h6>Mengetahui</h6><br>
              <h6>Manager</h6>
            </div>';

      $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

      $pdf->Output('report.pdf', 'I');
    }

    public function cetakInvoice($id)
    {
      $data = $this->barang->getInvoiceData($id);
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      // document informasi
      $pdf->SetCreator('Invoice');
      $pdf->SetTitle('Invoice Barang Keluar');
      $pdf->SetSubject('Barang Keluar');

      //header Data
      // $pdf->SetHeaderData('rubberman-logo.jpg',30,'','',array(203, 58, 44),array(0, 0, 0));
      // $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));

      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      //set margin
      $pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP + 10,PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

      $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

      //SET Scaling ImagickPixel
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      //FONT Subsetting
      $pdf->setFontSubsetting(true);

      $pdf->SetFont('helvetica','',14,'',true);

      $pdf->AddPage('L');

      $html=
        '<div>
          <h1 align="center">Invoice Bukti Pengeluaran Barang</h1>

          <table border="1">
            <tr>
              <th style="width:40px" align="center">No</th>
              <th style="width:300px" align="center">Part Number</th>
              <th style="width:300px" align="center">Part Name</th>
              <th style="width:200" align="center">Jumlah Barang Keluar</th>
            </tr>';
        $no = 0;
        foreach($data as $item) {
          $no++;
          $html .= '<tr>
            <td align="center">'.$no.'</td>
            <td align="center">'.$item->part_number.'</td>
            <td align="center">'.$item->part_name.'</td>
            <td align="center">'.$item->jumlah_barang_keluar.'</td>
          </tr>';
        }

        $html .='
            </table>
            <h6>Mengetahui</h6><br>
            <h6>Manager</h6>
          </div>';

      $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

      $pdf->Output('contoh_report.pdf', 'I');
    }

    public function getBarangByType()
    {
      $request = $this->input->post();
      $data = $this->barang->getDataByType($request['id']);

      $_view = '';
      $index = 0;

      if (count($data) > 0) {
        $_view .= '<div class="row mb-4">';
          $_view .= '<div class="col"><strong>Part Number</strong><br></div>';
          $_view .= '<div class="col"><strong>BOM</strong><br></div>';
          $_view .= '<div class="col"><strong>Jumlah Barang</strong><br></div>';
        $_view .= '</div>';

        foreach($data as $value) {
          $_view .= '<div class="row mb-4">';
            $_view .= '<div class="col">'.$value->part_number.'</div>';
            $_view .= '<div class="col">'.$value->bom.' Unit</div>';
            $_view .= '<div class="col">';
              $_view .= '<input type="text" class="form-control invoice-input w-50" name="jumlah_barang[]" id="jumlah_barang'.$value->part_number.'" placeholder="Masukan Jumlah" require onkeyup="checkSS('.$value->part_number.')" />';
              $_view .= '<input type="hidden" class="form-control invoice-input w-50" name="part_number[]" value="'.$value->part_number.'" />';
              $_view .= '<input type="hidden" class="form-control invoice-input w-50" name="id_barang_masuk[]" value="'.$value->id_barang_masuk.'" />';
              $_view .= '<input type="hidden" class="form-control invoice-input w-50" name="id_type_barang[]" value="'.$value->id_type_barang.'" />';
              $_view .= '<small class="badge badge-danger mt-2" style="display:none" id="error'.$value->part_number.'">Jumlah Melebihi Safety Stok</small>';
            $_view .= '</div>';
          $_view .= '</div>';
          $index++;
        }
      } else {
        $_view .= '<h2 class="mb-4 text-center">Data Barang Tidak ditemukan</h2>';
      }
      echo $_view;
    }

    public function actionAdd($table)
    {

      $request = $this->input->post();

      if ($table == 'app_master_barang') {
        $redirect = '/listMasterBarang';
      }

      if ($table == 'app_barangs') {
        $redirect = '/listPlanning';
      }

      if ($table == 'app_barang_masuk') {
        $redirect = '/listBarangMasuk';
      }

      if ($table == 'app_users') {
        $redirect = '/listUser';

        $request = [
          'nama' => $this->input->post('nama'),
          'email' => $this->input->post('email'),
          'password' => md5($this->input->post('password')),
          'role' => $this->input->post('role'),
        ];
      }

      $this->barang->addData($table, $request);

      redirect('barang'.$redirect);
    }

    public function generateNextSequence($currentSequence) {
      // Extract numeric part from the sequence
      $numericPart = intval(substr($currentSequence, 2));

      // Increment the numeric part
      $nextNumericPart = $numericPart + 1;

      // Concatenate the prefix and the incremented numeric part
      $nextSequence = substr($currentSequence, 0, 2) . $nextNumericPart;
      return $nextSequence;
    }

    public function actionUpdate($table, $id)
    {
      $idName = 'kode_barang';
      $redirect = '/';

      if ($table == 'app_master_barang') {
        $idName = 'kode_barang';
        $redirect = '/listMasterBarang';
      }

      if ($table == 'app_barang_masuk') {
        $idName = 'id';
        $redirect = '/listBarangMasuk';
      }

      if ($table == 'app_users') {
        $idName = 'id';
        $redirect = '/listUser';
      }

      $request = $this->input->post();

      if (isset($request['status_barang']) && $request['status_barang'] == 0) {
        $request = $this->generateData($this->input->post());
      }

      if ($table == 'app_users') {
        if ($this->input->post('password') != '') {
          $request = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'role' => $this->input->post('role'),
          ];
        } else {
          $request = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'role' => $this->input->post('role'),
          ];
        }
      }

      $this->barang->updateData($table, $request, $idName, $id);

      redirect('barang'.$redirect);
    }

    public function updateStatus()
    {
      $table = $this->input->post('table');
      $id = $this->input->post('id');
      $idName = $this->input->post('idName');
      $request = $this->input->post('data');

      $this->barang->updateData($table, $request, $idName, $id);
    }

    public function updateBarangKeluar()
    {
      $request = $this->input->post();
      $tmpArrayData = [];

      for ($i=0; $i < count($request['jumlah_barang']); $i++) {
        $tmpArrayData[] = [
          'part_number' => $request['part_number'][$i],
          'jumlah_barang' => $request['jumlah_barang'][$i],
          'id_barang_masuk' => $request['id_barang_masuk'][$i],
          'id_type_barang' => $request['id_type_barang'][$i],
        ];
      }

      for ($ii=0; $ii < count($tmpArrayData) ; $ii++) {
        if ($tmpArrayData[$ii]['jumlah_barang'] != "" || $tmpArrayData[$ii]['jumlah_barang'] != null) {
          $table = 'app_barang_masuk';
          $idName = 'id';
          $id = $tmpArrayData[$ii]['id_barang_masuk'];
          $getBarangMasuk = $this->barang->getDataByID('app_barang_masuk', 'id', $id);
          $updateJumlahBarang = $getBarangMasuk->jumlah_barang - $tmpArrayData[$ii]['jumlah_barang'];
          $request = array('jumlah_barang' => $updateJumlahBarang);

          $formBarangKeluar = [
            'part_number' => $tmpArrayData[$ii]['part_number'],
            'jumlah_barang_keluar' => $tmpArrayData[$ii]['jumlah_barang'],
            'tanggal_keluar' => date('Y-m-d'),
            'id_type' => $tmpArrayData[$ii]['id_type_barang'],
            'sisa_barang' => $updateJumlahBarang,
          ];

          $this->barang->updateData($table, $request, $idName, $id);
          $this->db->insert('app_barang_keluar', $formBarangKeluar);
        }
      }

      redirect('barang/listBarangKeluar');
    }

    private function generateData($request)
    {
      $data = [
        'id_type' => $request['id_type'],
        'jumlah_barang' => $request['jumlah_barang'],
        'status_permintaan' => 'pending',
        'status_barang' => 2,
      ];

      return $data;
    }

    public function actionDelete()
    {
      $id = $this->input->post('id');
      $idName = $this->input->post('idName');
      $table = $this->input->post('table');

      if ($table == 'app_barang') {
        $this->db->where('part_number', $id);
        $this->db->delete('app_barang_keluar');

        $this->db->where('part_number', $id);
        $this->db->delete('app_barang_masuk');

        $this->db->where($idName, $id);
        $this->db->delete($table);
      } else {
        $this->db->where($idName, $id);
        $this->db->delete($table);
      }
    }

    public function checkSafetyStock()
    {
      $id = $this->input->post('id');
      $idName = $this->input->post('idName');
      $table = $this->input->post('table');
      $jumlah_barang = $this->input->post('jumlah_barang');

      $getSS = $this->barang->getDataByID($table, $idName, $id);
      $getStok = $this->barang->getDataByID('app_barang_masuk', $idName, $id);
      $calculateStok = $getStok->jumlah_barang - $getSS->minimum_stok;

      $data = [
        'status' => 'success',
        'msg' => ''
      ];

      if ($calculateStok < $jumlah_barang) {
        $data = [
          'status' => 'failed',
          'msg' => 'Jumlah Stok Barang yang Anda inginkan dalam batas limit, silahkan lakukan PO'
        ];
      }

      echo json_encode($data);
    }
  }