<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Login extends CI_Controller {
    public function __construct()
    {
      parent::__construct();
      $this->load->model('M_login');
    }

    public function index()
    {
      $data = array(
        'title' => "Login"
      );
      $this->load->view('login', $data);
    }

    public function processLogin()
    {
      $this->form_validation->set_rules('email','Email','required');
      $this->form_validation->set_rules('password','Password','required');

      if($this->form_validation->run() == TRUE){
        $email = $this->input->post('email',TRUE);
        $password = $this->input->post('password',TRUE);
        $cek = $this->M_login->cek_user($email, $password);

        if( $cek->num_rows() != 1){
          $this->session->set_flashdata('msg','Email Dan Password Salah');
          redirect(base_url('login'));
        }else {
          $users = $cek->row();
          $data_session = array(
            'id' => $users->id,
            'nama' => $users->nama,
            'email' => $users->email,
            'status' => 'login',
            'role' => $users->role,
          );

          $this->session->set_userdata($data_session);

          redirect(base_url('barang'));
        }
      } else {
        redirect(base_url('login'));
      }
      // redirect('barang');
    }

    public function logout()
    {
      session_destroy();
      redirect('login');
    }
  }