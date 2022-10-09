<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

/**
 * Description of Ws
 *
 * @author RAMPA
 */
class Ws extends BaseController {
    
    private $model;
    private $modul;

    public function __construct() {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index() {
        $result = array();
        $status = "Maaf, bukan hak akses anda";
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }

    public function login() {
        $user = trim($this->request->getPost('username'));
        $pass = trim($this->request->getPost('password'));
        $enkrip_pass = $this->modul->enkrip_pass($pass);

        $result = array();
        $jml = $this->model->getAllQR("SELECT count(*) as jml FROM users where nrp = '" . $user . "';")->jml;
        if ($jml > 0) {
            $jml1 = $this->model->getAllQR("select count(*) as jml from users where nrp = '" . $user . "' and pass = '" . $enkrip_pass . "';")->jml;
            if ($jml1 > 0) {
                $data = $this->model->getAllQR("select a.idusers, a.nrp, a.nama, a.idrole, b.nama_role, c.idpangkat, c.nama_pangkat, d.idkorps, d.nama_korps, a.foto from users a, role b, pangkat c, korps d where a.nrp = '" . $user . "' and a.idrole = b.idrole and a.idpangkat = c.idpangkat and a.idkorps = d.idkorps;");
                if ($data->idrole <> "R00001") {
                    $def_foto = base_url() . '/images/noimg.jpg';
                    if (strlen($data->foto) > 0) {
                        if (file_exists($this->modul->getPathApp() . $data->foto)) {
                            $def_foto = base_url() . '/uploads/' . $data->foto;
                        }
                    }

                    array_push($result, array(
                        'status' => "oke",
                        'idusers' => $data->idusers,
                        'nrp' => $data->nrp,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'idpangkat' => $data->idpangkat,
                        'nama_pangkat' => $data->nama_pangkat,
                        'idkorps' => $data->idkorps,
                        'nama_korps' => $data->nama_korps,
                        'foto' => $def_foto
                    ));
                } else {
                    $status = "Bukan hak akses anda";
                    array_push($result, array('status' => $status));
                }
            } else {
                $status = "Anda tidak berhak mengakses !";
                array_push($result, array('status' => $status));
            }
        } else {
            $status = "Maaf, user tidak ditemukan !";
            array_push($result, array('status' => $status));
        }
        echo json_encode(array("result" => $result));
    }

    public function pangkat() {
        $result = array();
        $list = $this->model->getAllQ("SELECT * FROM pangkat where idpangkat <> 'P00001';");
        foreach ($list->getResult() as $row) {
            array_push($result, array(
                'kode' => $row->idpangkat,
                'namapangkat' => $row->nama_pangkat,
            ));
        }
        echo json_encode(array("result" => $result));
    }

    public function korps() {
        $result = array();
        $list = $this->model->getAll("korps");
        foreach ($list->getResult() as $row) {
            array_push($result, array(
                'kode' => $row->idkorps,
                'namakorps' => $row->nama_korps,
            ));
        }
        echo json_encode(array("result" => $result));
    }

    public function simpanprofile() {
        $data = array(
            'nrp' => $this->request->getPost('nrp'),
            'nama' => $this->request->getPost('nama'),
            'idkorps' => $this->request->getPost('korps'),
            'idpangkat' => $this->request->getPost('pangkat')
        );
        $kond['idusers'] = $this->request->getPost('kode');
        $update = $this->model->update("users", $data, $kond);
        if ($update == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }

        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
}
