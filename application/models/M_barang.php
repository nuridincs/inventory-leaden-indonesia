<?php

  class M_barang extends CI_Model
  {
    public function getData($table)
    {
      $query = $this->db->get($table);

      return $query->result();
    }

    public function getJoinData($uniqid, $table1, $table2)
    {
      $query = $this->db->select('*')
              ->from($table1)
              ->join($table2, $table2.'.'.$uniqid.'='.$table1.'.'.$uniqid)
              ->get();

      return $query->result();
    }
  }