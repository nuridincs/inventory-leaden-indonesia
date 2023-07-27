<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?php echo base_url(); ?>barang">PT. ABC</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?php echo base_url(); ?>barang">LI</a>
    </div>
    <ul class="sidebar-menu">
      <li class="<?php echo $this->uri->segment(2) == '' || $this->uri->segment(2) == 'index' || $this->uri->segment(2) == 'index_0' ? 'active' : ''; ?>">
        <a href="<?php echo base_url(); ?>barang" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
      </li>
      <?php
        $role = ['manager', 'admin'];
        if (in_array($this->session->userdata['role'], $role)){
      ?>
        <li class="<?php echo $this->uri->segment(2) == 'listMasterBarang' ? 'active' : ''; ?>">
          <a href="<?= base_url('barang/listMasterBarang') ?>" class="nav-link"><i class="fas fa-folder"></i> <span>Master Barang</span></a>
        </li>
        <li class="<?php echo $this->uri->segment(2) == 'listPlanning' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>barang/listPlanning"><i class="fas fa-folder-open"></i> <span>Planning - Produksi</span></a>
        </li>
        <!-- <li class="<?php // echo $this->uri->segment(2) == 'listBarangKeluar' ? 'active' : ''; ?>">
          <a href="<?php // echo base_url(); ?>barang/listBarangKeluar" class="nav-link"><i class="fas fa-folder-minus"></i> <span>Barang Keluar</span></a>
        </li> -->
        <!-- <li class="<?php //echo $this->uri->segment(2) == 'listUser' ? 'active' : ''; ?>">
          <a href="<?php //echo base_url(); ?>barang/listUser" class="nav-link"><i class="fas fa-users"></i> <span>Kelola User</span></a>
        </li> -->
        <li class="<?php echo $this->uri->segment(2) == 'laporan' ? 'active' : ''; ?>">
          <a href="<?php echo base_url(); ?>barang/laporan" class="nav-link"><i class="fas fa-th"></i> <span>Laporan</span></a>
        </li>
        <li class="<?php //echo $this->uri->segment(2) == 'laporan' ? 'active' : ''; ?>">
          <a href="<?php echo base_url(); ?>login/logout" class="nav-link"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </li>
        <?php } else { ?>
        <!-- <li class="<?php //echo $this->uri->segment(2) == 'listBarangKeluar' ? 'active' : ''; ?>">
          <a href="<?php //echo base_url(); ?>barang/listBarangKeluar" class="nav-link"><i class="fas fa-folder-minus"></i> <span>Barang Keluar</span></a>
        </li> -->
        <?php } ?>
    </ul>
  </aside>
</div>
