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
        'title' => "PT. LEADEN INDONESIA | Dashboard",
      );

      $this->load->view('dashboard', $data);
    }

    public function listMasterBarang()
    {
      $data = array(
        'title' => "PT. LEADEN INDONESIA | Master Barang",
        'barang' => $this->barang->getDataMasterBarang()
      );

      $this->load->view('barang/list', $data);
    }

    public function listBarangMasuk()
    {
      $data = array(
        'title' => "PT. LEADEN INDONESIA | Barang Masuk",
        'barang' => $this->barang->getJoinData('part_number', 'app_barang', 'app_barang_masuk')
      );

      $this->load->view('barang_masuk/list', $data);
    }

    public function listBarangKeluar()
    {
      $data = array(
        'title' => "PT. LEADEN INDONESIA | Barang Masuk",
        // 'barang' => $this->barang->getJoinData('part_number', 'app_barang_masuk', 'app_barang_keluar')
        'barang' => $this->barang->getDataBarangKeluar()
      );

      $this->load->view('barang_keluar/list', $data);
    }

    public function listUser()
    {
      $data = array(
        'title' => "PT. LEADEN INDONESIA | Data User",
        'user' => $this->barang->getData('app_users')
      );

      $this->load->view('users/list', $data);
    }

    public function laporan()
    {
      $data = array(
        'title' => "PT. LEADEN INDONESIA | Laporan",
        'laporan' => $this->barang->getLaporan()
        // 'barang' => $this->barang->getJoinData('part_number', 'app_barang', 'app_barang_masuk')
      );
      // print_r($data);die;

      $this->load->view('laporan', $data);
    }

    public function form($form, $action, $id)
    {
      $dtlBarang = [];

      if($action == 'edit') {
        $dtlBarang = $this->getDataByAction($form, $id);
      }

      $data = array(
        'title' => "PT. LEADEN INDONESIA | Form ". $form,
        'action' => $action,
        'barang' => $this->getData($form, 'app_barang'),
        'type' => $this->getData($form, 'app_type'),
        'role' => $this->barang->getData('app_role'),
        'dtlBarang' => $dtlBarang
      );

      $this->load->view('form/'.$form, $data);
    }

    private function getDataByAction($form, $id)
    {
      $result = [];
      if($form == 'form_barang') {
        $result = $this->barang->getDataByID('app_barang', 'part_number', $id);
      }

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
      if($form == 'form_permintaan' || $form == 'form_siapkan_barang') {
        $result = $this->barang->getData($table);
      }

      return $result;
    }

    public function cetakLaporan($id_type = null)
    {
      $data = $this->barang->getLaporan($id_type);

      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      // document informasi
      $pdf->SetCreator('Inventory Persidiaan Barang');

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
        $html .= '<h1 align="center">Laporan Barang</h1>';
      }
      $html .='
          <table border="1" width="100" align="center">
            <tr>
              <th style="width:40px" align="center">No</th>
              <th style="width:150px" align="center">Part Number</th>
              <th style="width:150px" align="center">Part Name</th>
              <th style="width:100px" align="center">Type</th>
              <th style="width:150px" align="center">Tanggal Masuk</th>
              <th style="width:150px" align="center">Tanggal Keluar</th>
              <th style="width:100px" align="center">Jumlah Barang Keluar</th>
              <th style="width:140px" align="center">Sisa Barang</th>
            </tr>';

            $no = 0;
            foreach($data as $item) {
              $no++;
              $html .= '<tr>
                <td>'.$no.'</td>
                <td>'.$item->part_number.'</td>
                <td>'.$item->part_name.'</td>
                <td>'.$item->id_type.'</td>
                <td>'.date('Y-m-d', strtotime($item->tanggal_masuk)).'</td>
                <td>'.$item->tanggal_keluar.'</td>
                <td>'.$item->jumlah_barang_keluar.'</td>
                <td>'.$item->sisa_barang.'</td>
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

      if ($table == 'app_barang') {
        $redirect = '/listMasterBarang';
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

    public function actionUpdate($table, $id)
    {
      $idName = 'part_number';
      $redirect = '/';

      if ($table == 'app_barang') {
        $idName = 'part_number';
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