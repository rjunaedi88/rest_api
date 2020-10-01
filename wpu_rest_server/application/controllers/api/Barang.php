<?php


use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php'; 

class Barang extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('BarangModel', 'barang');
    }

    public function index_get()
    {

        $id = $this->get('id_brg');

        if ($id === null) {
            $barang = $this->barang->getBarang();
        } else {
            $barang = $this->barang->getBarang($id);
        }
        
        if ($barang) {
            $this->response([
                'status' => TRUE,
                'data' => $barang
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }

    public function index_delete()
    {
        $id = $this->delete('id_brg');

        if ($id === null) {
            $this->response([
                'status' => FALSE,
                'message' => 'harap input id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ( $this->barang->hapusBarang($id) > 0 ) {
                $this->response([
                    'status' => true,
                    'id_brg' => $id,
                    'mesaage' => 'deleted success'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'id yang dimasukkan tidak ada'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nama_brg'      => $this->post('nama_brg'),
            'keterangan'    => $this->post('keterangan'),
            'kategori'      => $this->post('kategori'),
            'harga'         => $this->post('harga'),
            'stok'          => $this->post('stok'),
            'gambar_brg'    => $this->post('gambar_brg')
        ];

        if ($this->barang->tambahBarang($data) > 0) {
            $this->response([
                'status' => true,
                'mesaage' => 'barang berhasil diinput'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'barang gagal diinput'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id_brg');

        $data = [
            'nama_brg'      => $this->put('nama_brg'),
            'keterangan'    => $this->put('keterangan'),
            'kategori'      => $this->put('kategori'),
            'harga'         => $this->put('harga'),
            'stok'          => $this->put('stok'),
            'gambar_brg'    => $this->put('nama_brg')
        ];

        if ($this->barang->ubahBarang($data, $id) > 0) {
            $this->response([
                'status' => true,
                'mesaage' => 'barang berhasil diupadte'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'barang gagal diupdate'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}