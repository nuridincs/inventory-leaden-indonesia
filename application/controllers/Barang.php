<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Barang extends CI_Controller {
    public function __construct()
    {
      parent::__construct();
      // $this->load->library('Pdf');

      $this->load->model('M_barang', 'barang');

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

    public function form($form)
    {
      $data = array(
        'title' => "PT. FAJAR UTAMA | Form ". $form,
        // 'barang' => $this->barang->getJoinData('part_number', 'app_barang', 'app_barang_masuk')
      );

      $this->load->view('form/'.$form, $data);
    }
  }