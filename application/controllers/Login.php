<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Login extends CI_Controller {
    public function index()
    {
      $data = array(
        'title' => "Login"
      );
      $this->load->view('login', $data);
    }

    public function processLogin()
    {
      redirect('barang');
    }

    public function logout()
    {
      // session_destroy();
      redirect('login');
    }
  }