<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Wssakitdetil extends BaseController {

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

    public function ajax_add_detil() {
        $data = array(
            'idsakit_detil' => $this->model->autokode("D", "idsakit_detil", "sakit_detil", 2, 7),
            'idsakit' => $this->request->getPost('kode_detil'),
            'nama_barang' => $this->request->getPost('nama'),
            'gejala' => $this->request->getPost('gejala'),
            'kegiatan' => $this->request->getPost('kegiatan'),
            'keterangan' => $this->request->getPost('keterangan'),
            'foto' => ''
        );
        $simpan = $this->model->add("sakit_detil", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }

    public function ajax_add_detil_file() {
        $dir = $this->modul->setPathApp();
        if (isset($_FILES['image']['name'])) {
            $file_name_temp = basename($_FILES['image']['name']);
            $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $file_name_temp);
            $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
                if ($_FILES["image"]["size"] < 4000001) {
                    $file = $dir . $file_name;

                    // hapus file jika ada yang lama
                    // $lawas = $this->model->getAllQR("SELECT foto FROM users where idusers = '" . $idusers . "';")->foto;
                    // if (strlen($lawas) > 0) {
                    //     if (file_exists($this->modul->getPathApp() . $lawas)) {
                    //         unlink($this->modul->getPathApp() . $lawas);
                    //     }
                    // }

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $file)) {
                        $data = array(
                            'idsakit_detil' => $this->model->autokode("D", "idsakit_detil", "sakit_detil", 2, 7),
                            'idsakit' => $this->request->getPost('kode_detil'),
                            'nama_barang' => $this->request->getPost('nama'),
                            'gejala' => $this->request->getPost('gejala'),
                            'kegiatan' => $this->request->getPost('kegiatan'),
                            'keterangan' => $this->request->getPost('keterangan'),
                            'foto' => $file_name
                        );
                        $simpan = $this->model->add("sakit_detil", $data);
                        if ($simpan == 1) {
                            $status = "Data tersimpan";
                        } else {
                            $status = "Data gagal tersimpan";
                        }
                    } else {
                        $status = "Terjadi kesesalahan, silakan coba lagi";
                    }
                } else {
                    $status = "Batas ukuran file 4 MB";
                }
            } else {
                $status = "Hanya mendukung format gambar .png, .jpg and .jpeg";
            }
        } else {
            $status = "Silakan mencoba dengan metode POST";
        }

        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }

    public function hapusdetil() {
        $kode = $this->request->getPost('kode');
        $logo = $this->model->getAllQR("SELECT foto FROM sakit_detil where idsakit_detil = '" . $kode . "';")->foto;
        if (strlen($logo) > 0) {
            if (file_exists($this->modul->getPathApp() . $logo)) {
                unlink($this->modul->getPathApp() . $logo);
            }
        }

        $kond['idsakit_detil'] = $kode;
        $hapus = $this->model->delete("sakit_detil", $kond);
        if ($hapus == 1) {
            $status = "Data terhapus";
        } else {
            $status = "Data gagal terhapus";
        }

        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
}