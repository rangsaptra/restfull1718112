<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class model_kamera extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }
  public function get($id = null, $limit = 5, $offset = 0)
  {
    if ($id === null) {
      return $this->db->get('tb_produk', $limit, $offset);
    } else {
      return $this->db->get_where('tb_produk', ['id_kmr' => $id])->result_array();
    }
  }
  
  public function count()
  {
    return $this->db->get('tb_produk')->num_rows();
  }

  public function add($data)
  {
    try{
      $this->db->insert('tb_produk', $data);
      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi Kesalahan :' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }
  public function update($id, $data)
  {
    try{
      $this->db->update('tb_produk', $data, ['id_kmr' => $id]);
      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi Kesalahan :' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }

  public function delete($id)
  {
    try{
      $this->db->delete('tb_produk',['id_kmr' => $id]);
      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi Kesalahan :' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }
}