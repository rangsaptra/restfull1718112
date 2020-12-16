<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Kamera extends RESTController 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_kamera','kmr');
    } 

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $p = $this->get('id');
            $p = (empty($p)?1:$p);
            $jml_data = $this->kmr->count();
            $jml_page = ceil($jml_data/5);
            $start = ($p - 1)*5;
            $list = $this->kmr->get(null, 5, $start);
            if ($list) {
                $data = [
                    'status' => true,
                    'page' => $p,
                    'jml_data' => $jml_data,
                    'jml_page' => $jml_page,
                    'data' => $list
                ];
            }else {
                $data = [
                    'status' => false,
                    'msg' => 'Data tidak ada'
                ];
            }
            $this->response($data, RestController::HTTP_OK);
        }else {
            $data = $this->kmr->get($id);
            if ($data) {
                $this->response(['status' => true, 'data' => $data], RestController::HTTP_OK);
            }else {
                $this->response(['status' => true, 'msg' => $id], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {
      $data = [
        'id_kmr' => $this->post('id_kmr', true),
        'merk' => $this->post('merk', true),//nama kolom 2 pada tabel
        'tahun' => $this->post('tahun', true),//nama kolom 3 pada tabel
        'tipe' => $this->post('tipe', true),//nama kolom 4 pada tabel
        'garansi' => $this->post('garansi', true),//nama kolom 5 pada tabel
        'harga' => $this->post('harga', true),//nama kolom 6 pada tabel
      ];
      $simpan = $this->kmr->add($data);
      if ($simpan['status']) {
        $this->response(['status' => true, 'msg' => $simpan['data'] . ' Data berhasil ditambahkan'], RestController::HTTP_CREATED);
      } else {
        $this->response(['status' => false, 'msg' => $simpan['msg']], RestController::HTTP_INTERNAL_ERROR);
      }
    }
    public function index_put()
    {
      $data = [
        'id_kmr' => $this->put('id_kmr', true),
        'merk' => $this->put('merk', true),
        'tahun' => $this->put('tahun', true),
        'tipe' => $this->put('tipe', true),
        'garansi' => $this->put('garansi', true),
        'harga' => $this->put('harga', true),
      ];
      $id = $this->put('id_kmr', true);
      if ($id === null) {
        $this->response(['status' => false, 'msg' => 'Masukan ID Kamera'], RestController::HTTP_BAD_REQUEST);
      }
      $simpan = $this->kmr->update($id, $data);
      if ($simpan['status']) {
        $status = (int)$simpan['data'];
        if ($status > 0)
          $this->response(['status' => true, 'msg' => $simpan['data'] . ' Data Berubah'], RestController::HTTP_OK);
        else
          $this->response(['status' => false, 'msg' => 'Tidak ada data yang di update'], RestController::HTTP_BAD_REQUEST);
      } else {
        $this->response(['status' => false, 'msg' => $simpan['msg']], RestController::HTTP_INTERNAL_ERROR);
      }
    }

    public function index_delete()
    {
      $id = $this->delete('id_kmr', true);
      if ($id === null) {
        $this->response(['status' => false, 'msg' => 'Masukan ID kamera Data Yang akan di hapus'], RestController::HTTP_BAD_REQUEST);
      }
      $delete = $this->kmr->delete($id);
      if ($delete['status']) {
        $status = (int)$delete['data'];
        if ($status > 0)
          $this->response(['status' => true, 'msg' => $id . ' Data Terhapus'], RestController::HTTP_OK);
        else
          $this->response(['status' => false, 'msg' => 'Tidak ada data yang di hapus'], RestController::HTTP_BAD_REQUEST);
      } else {
        $this->response(['status' => false, 'msg' => $delete['msg']], RestController::HTTP_INTERNAL_ERROR);
      }
    }
}
