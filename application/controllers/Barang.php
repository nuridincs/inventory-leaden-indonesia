<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Barang extends CI_Controller {
    public function __construct()
    {
      parent::__construct();
      // $this->load->library('Pdf');

      $this->load->model('M_barang', 'barang');
      $this->load->library('Pdf');

      // $cekUserLogin = $this->session->userdata('status');

      // if ($cekUserLogin != 'login') {
      //   redirect('auth');
      // }
    }

    public function index()
    {
      $data = array(
        'title' => "PT. FAJAR UTAMA | Dashboard",
      );

      $this->load->view('dashboard', $data);
    }

    public function listMasterBarang()
    {
      $data = array(
        'title' => "PT. FAJAR UTAMA | Master Barang",
        'barang' => $this->barang->getData('app_barang')
      );

      $this->load->view('barang/list', $data);
    }

    public function listBarangMasuk()
    {
      $data = array(
        'title' => "PT. FAJAR UTAMA | Barang Masuk",
        'barang' => $this->barang->getJoinData('part_number', 'app_barang', 'app_barang_masuk')
      );

      $this->load->view('barang_masuk/list', $data);
    }

    public function listBarangKeluar()
    {
      $data = array(
        'title' => "PT. FAJAR UTAMA | Barang Masuk",
        'barang' => $this->barang->getJoinData('part_number', 'app_barang_masuk', 'app_barang_keluar')
      );

      $this->load->view('barang_keluar/list', $data);
    }

    public function listUser()
    {
      $data = array(
        'title' => "PT. FAJAR UTAMA | Data User",
        'user' => $this->barang->getData('app_users')
      );

      $this->load->view('users/list', $data);
    }

    public function laporan()
    {
      $data = array(
        'title' => "PT. FAJAR UTAMA | Laporan",
        'laporan' => $this->barang->getLaporan()
        // 'barang' => $this->barang->getJoinData('part_number', 'app_barang', 'app_barang_masuk')
      );

      $this->load->view('laporan', $data);
    }

    public function form($form, $action)
    {
      $data = array(
        'title' => "PT. FAJAR UTAMA | Form ". $form,
        'action' => $action,
        'barang' => $this->getData($form, 'app_barang'),
        'type' => $this->getData($form, 'app_type'),
      );

      $this->load->view('form/'.$form, $data);
    }

    public function getData($form, $table)
    {
      $result = [];
      if($form == 'form_permintaan' || $form == 'form_siapkan_barang') {
        $result = $this->barang->getData($table);
      }

      return $result;
    }

    public function cetakLaporan()
    {
      $data = $this->barang->getLaporan();

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

      $html=
        '<div>
          <h1 align="center">Laporan Barang</h1>

          <table border="1" width="100" align="center">
            <tr>
              <th style="width:40px" align="center">No</th>
              <th style="width:150px" align="center">Part Number</th>
              <th style="width:150px" align="center">Type</th>
              <th style="width:150px" align="center">Tanggal Masuk</th>
              <th style="width:150px" align="center">Tanggal Keluar</th>
              <th style="width:200px" align="center">Jumlah Barang Keluar</th>
              <th style="width:140px" align="center">Sisa Barang</th>
            </tr>';

            $no = 0;
            foreach($data as $item) {
              $no++;
              $html .= '<tr>
                <td>'.$no.'</td>
                <td>'.$item->part_number.'</td>
                <td>'.$item->id_type.'</td>
                <td>'.date('Y-m-d', strtotime($item->tanggal_masuk)).'</td>
                <td>'.$item->tanggal_keluar.'</td>
                <td>'.$item->jumlah_barang_keluar.'</td>
                <td>'.$item->jumlah_barang.'</td>
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
              <th style="width:200px" align="center">Part Number</th>
              <th style="width:200px" align="center">Tanggal Masuk</th>
              <th style="width:200px" align="center">Tanggal Keluar</th>
              <th style="width:250" align="center">Jumlah Barang Keluar</th>
            </tr>';
        $no = 0;
        foreach($data as $item) {
          $no++;
          $html .= '<tr>
            <td align="center">'.$no.'</td>
            <td align="center">'.$item->part_number.'</td>
            <td align="center">'.$item->tanggal_masuk.'</td>
            <td align="center">'.$item->tanggal_keluar.'</td>
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
                $_view .= '<input type="text" class="form-control invoice-input w-50" placeholder="Masukan Jumlah" require />';
            $_view .= '</div>';
          $_view .= '</div>';
        }
      } else {
        $_view .= '<h2 class="mb-4 text-center">Data Barang Tidak ditemukan</h2>';
      }
      echo $_view;
    }
  }