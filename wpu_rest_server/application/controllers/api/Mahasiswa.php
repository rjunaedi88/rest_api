<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';  

class Mahasiswa extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Mahasiswa_model', 'mhs_model');
    }

    public function index_get()
    {
        $id = $this->get('id');

        if ($id === null) {
                $mahasiswa = $this->mhs_model->getMahasiswa();
        } else {
                $mahasiswa = $this->mhs_model->getMahasiswa($id);
        }
        
        if ($mahasiswa) {
            $this->response([
                'status' => TRUE,
                'data' => $mahasiswa
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
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => FALSE,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else { // jika id nya ada
            if ($this->mhs_model->deleteMahasiswa($id) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'mesaage' => 'deleted success'
                ], REST_Controller::HTTP_OK);
            } else {
                // not found
                $this->response([
                    'status' => FALSE,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if ($this->mhs_model->createMahasiswa($data) > 0 ) {
            $this->response([
                'status' => true,
                'mesaage' => 'new mahasiswa has been created'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'failed to create new data mahasiswa'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');

        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if ($this->mhs_model->updateMahasiswa($data, $id) > 0 ) {
            $this->response([
                'status' => true,
                'mesaage' => 'mahasiswa has been updated'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'failed to update new data mahasiswa'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}