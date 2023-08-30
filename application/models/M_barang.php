<?php

  class M_barang extends CI_Model
  {
    public function getData($table)
    {
      $query = $this->db->get($table);

      return $query->result();
    }

    public function getJoinData($uniqid, $table1, $table2, $isFlag = false)
    {
      $query = $this->db->select('*')
              ->from($table1)
              ->join($table2, $table2.'.'.$uniqid.'='.$table1.'.'.$uniqid)
              ->get();
      // echo $this->db->last_query();die;

      return $query->result();
    }

    public function getPlanningList()
    {
      $this->db->select('*');
      $this->db->from('app_barangs');
      $this->db->join('app_master_barang', 'app_master_barang.kode_barang=app_barangs.kode_barang', 'left');
      $this->db->where('DATE(app_barangs.tgl_masuk)', date('Y-m-d'));

      $query = $this->db->get();

      return $query->result();
    }

    public function getDataByStatus($status = array('proses-qc'), $isMultiple = false)
    {
      $this->db->select('*');
      $this->db->from('app_barangs');
      $this->db->join('app_master_barang', 'app_master_barang.kode_barang = app_barangs.kode_barang', 'left');
      $this->db->where_in('app_barangs.status', $status);
      $this->db->order_by('app_barangs.tgl_planning', 'desc');
      $query = $this->db->get();

      return $query->result();
    }

    public function getLaporanProduksi($id_type = null)
    {
      $this->db->select('*');
      $this->db->from('app_barangs');
      $this->db->join('app_master_barang', 'app_master_barang.kode_barang=app_barangs.kode_barang', 'left');

      $query = $this->db->get();

      return $query->result();
    }

    public function getLaporanProduksiV2($selectedFilter = null)
    {
        $this->db->select('*');
        $this->db->from('app_barangs');
        $this->db->join('app_master_barang', 'app_master_barang.kode_barang=app_barangs.kode_barang', 'left');

        if (isset($selectedFilter)) {
          if ($selectedFilter == 'ok') {
            $this->db->where('app_barangs.qty_ok !=', 0);
          } elseif ($selectedFilter == 'reject') {
            $this->db->where('app_barangs.qty_reject !=', 0);
          }
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function addData($table, $data)
    {
      $this->db->insert($table, $data);
    }

    public function updateData($table, $data, $idName, $id)
    {
      $this->db->where($idName, $id);
      $this->db->update($table, $data);
    }

    public function getLastKodeBarang() {
      $query = $this->db->select('*')
              ->from('app_master_barang')
              ->order_by('created_at', 'desc')
              ->limit(1)
              ->get();

      return $query->row();
    }

    public function getLastKodePlanning() {
      $query = $this->db->select('*')
              ->from('app_barangs')
              ->order_by('tgl_masuk', 'desc')
              ->limit(1)
              ->get();

      return $query->row();
    }

    public function getDataByID($table, $idName, $id)
    {
      $query = $this->db->select('*')
              ->from($table)
              ->where($idName, $id)
              ->get();

      return $query->row();
    }
  }