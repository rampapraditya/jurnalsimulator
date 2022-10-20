<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Oprsim extends BaseController {

    private $model;
    private $modul;

    public function __construct() {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index() {
        if (session()->get("logged_in")) {
            $data['username'] = session()->get("username");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nmrole'] = $this->model->getAllQR("SELECT nama_role FROM role where idrole = '" . $data['role'] . "';")->nama_role;

            // membaca foto profile
            $def_foto = base_url() . '/images/noimg.png';
            $pro_tersimpan = $this->model->getAllQR("select * from users where idusers = '" . session()->get("username") . "';");
            if (strlen($pro_tersimpan->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $pro_tersimpan->foto)) {
                    $def_foto = base_url() . '/uploads/' . $pro_tersimpan->foto;
                }
            }
            $data['foto_profile'] = $def_foto;
            ;

            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if ($jml_identitas > 0) {
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $deflogo = base_url() . '/images/noimg.png';
                if (strlen($tersimpan->logo) > 0) {
                    if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                        $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            } else {
                $data['logo'] = base_url() . '/images/noimg.png';
            }
            $data['curdate'] = $this->modul->TanggalSekarang();
            $data['curtime'] = $this->modul->WaktuSekarang2();

            $data['simulator'] = $this->model->getAll("simulator");

            echo view('head', $data);
            echo view('menu');
            echo view('operasi/index');
            echo view('foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if (session()->get("logged_in")) {
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT *, 'Pemanasan' as model, idsimulator as idsuratmasuk FROM osp 
                union 
                SELECT *, 'Latihan' as model, idsuratmasuk FROM osl order by tanggal;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;

                $deflogo = base_url() . '/images/noimg.png';
                if (strlen($row->foto) > 0) {
                    if (file_exists($this->modul->getPathApp() . $row->foto)) {
                        $deflogo = base_url() . '/uploads/' . $row->foto;
                    }
                }
                $val[] = '<img src="' . $deflogo . '" class="img-thumbnail" style="width: 70px; height: auto;">';

                if ($row->model == "Pemanasan") {
                    $val[] = $this->model->getAllQR("SELECT nama_simulator FROM simulator where idsimulator = '" . $row->idsuratmasuk . "';")->nama_simulator;
                } else if ($row->model == "Latihan") {
                    $cek = $this->model->getAllQR("SELECT count(b.nama_simulator) as jml FROM suratmasuk a, simulator b where a.idsimulator = b.idsimulator and a.idsuratmasuk = '" . $row->idsuratmasuk . "';")->jml;
                    if ($cek > 0) {
                        $val[] = $this->model->getAllQR("SELECT b.nama_simulator FROM suratmasuk a, simulator b where a.idsimulator = b.idsimulator and a.idsuratmasuk = '" . $row->idsuratmasuk . "';")->nama_simulator;
                    } else {
                        $val[] = "";
                    }
                }

                $val[] = $row->kegiatan;
                $val[] = $row->tanggal;
                $val[] = $row->waktu_on;
                $val[] = $row->waktu_off;
                $val[] = $row->kondisi;
                $val[] = $row->model;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti(' . "'" . $row->idop_simulator . "'" . ')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus(' . "'" . $row->idop_simulator . "'" . ',' . "'" . $no . "'" . ',' . "'" . $row->model . "'" . ')">Hapus</button>'
                        . '</div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxrenlat() {
        if (session()->get("logged_in")) {
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT suratmasuk.*, users.nrp, users.nama, simulator.nama_simulator FROM suratmasuk 
                LEFT JOIN users ON suratmasuk.idusers = users.idusers 
                LEFT JOIN simulator ON suratmasuk.idsimulator = simulator.idsimulator");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_simulator;
                $val[] = $row->tanggal;
                $val[] = $row->nosurat;
                $val[] = $row->dari;
                $val[] = $row->perihal;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="pilih(' . "'" . $row->idsuratmasuk . "'" . ',' . "'" . $row->nama_simulator . "'" . ')">Pilih</button>'
                        . '</div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add() {
        if (session()->get("logged_in")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $status = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $status = $this->simpan_dengan();
                }
            } else {
                $status = $this->simpan_tanpa();
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function simpan_dengan() {
        $idusers = session()->get("username");
        $mode = $this->request->getPost('mode');
        if ($mode == "Pemanasan") {
            $file = $this->request->getFile('file');
            $namaFile = $file->getRandomName();
            $info_file = $this->modul->info_file($file);

            if (file_exists($this->modul->getPathApp() . $namaFile)) {
                $status = "Gunakan nama file lain";
            } else {
                $status_upload = $file->move($this->modul->getPathApp(), $namaFile);
                if ($status_upload) {
                    $data = array(
                        'idop_simulator' => $this->model->autokode("P", "idop_simulator", "osp", 2, 7),
                        'tanggal' => $this->request->getPost('tanggal'),
                        'kegiatan' => $this->request->getPost('kegiatan'),
                        'waktu_on' => $this->request->getPost('waktuon'),
                        'waktu_off' => $this->request->getPost('waktuoff'),
                        'kondisi' => $this->request->getPost('kondisi'),
                        'keterangan' => $this->request->getPost('keterangan'),
                        'foto' => $namaFile,
                        'idusers' => $idusers,
                        'idsimulator' => $this->request->getPost('simulator')
                    );
                    $simpan = $this->model->add("osp", $data);
                    if ($simpan == 1) {
                        $status = "Data tersimpan";
                    } else {
                        $status = "Data gagal tersimpan";
                    }
                } else {
                    $status = "File gagal terupload";
                }
            }
        } else if ($mode == "Latihan") {
            $file = $this->request->getFile('file');
            $namaFile = $file->getRandomName();
            $info_file = $this->modul->info_file($file);

            if (file_exists($this->modul->getPathApp() . $namaFile)) {
                $status = "Gunakan nama file lain";
            } else {
                $status_upload = $file->move($this->modul->getPathApp(), $namaFile);
                $status = $status_upload;
                if ($status_upload) {
                    $data = array(
                        'idop_simulator' => $this->model->autokode("L", "idop_simulator", "osl", 2, 7),
                        'tanggal' => $this->request->getPost('tanggal'),
                        'kegiatan' => $this->request->getPost('kegiatan'),
                        'waktu_on' => $this->request->getPost('waktuon'),
                        'waktu_off' => $this->request->getPost('waktuoff'),
                        'kondisi' => $this->request->getPost('kondisi'),
                        'keterangan' => $this->request->getPost('keterangan'),
                        'foto' => $namaFile,
                        'idusers' => $idusers,
                        'idsuratmasuk' => $this->request->getPost('kode_renlat')
                    );
                    $simpan = $this->model->add("osl", $data);
                    if ($simpan == 1) {
                        $status = "Data tersimpan";
                    } else {
                        $status = "Data gagal tersimpan";
                    }
                } else {
                    $status = "File gagal terupload";
                }
            }
        }
        return $status;
    }

    private function simpan_tanpa() {
        $idusers = session()->get("username");
        $mode = $this->request->getPost('mode');
        if ($mode == "Pemanasan") {
            $data = array(
                'idop_simulator' => $this->model->autokode("P", "idop_simulator", "osp", 2, 7),
                'tanggal' => $this->request->getPost('tanggal'),
                'kegiatan' => $this->request->getPost('kegiatan'),
                'waktu_on' => $this->request->getPost('waktuon'),
                'waktu_off' => $this->request->getPost('waktuoff'),
                'kondisi' => $this->request->getPost('kondisi'),
                'keterangan' => $this->request->getPost('keterangan'),
                'foto' => '',
                'idusers' => $idusers,
                'idsimulator' => $this->request->getPost('simulator')
            );
            $simpan = $this->model->add("osp", $data);
            if ($simpan == 1) {
                $status = "Data tersimpan";
            } else {
                $status = "Data gagal tersimpan";
            }
        } else if ($mode == "Latihan") {
            $data = array(
                'idop_simulator' => $this->model->autokode("L", "idop_simulator", "osl", 2, 7),
                'tanggal' => $this->request->getPost('tanggal'),
                'kegiatan' => $this->request->getPost('kegiatan'),
                'waktu_on' => $this->request->getPost('waktuon'),
                'waktu_off' => $this->request->getPost('waktuoff'),
                'kondisi' => $this->request->getPost('kondisi'),
                'keterangan' => $this->request->getPost('keterangan'),
                'foto' => '',
                'idusers' => $idusers,
                'idsuratmasuk' => $this->request->getPost('kode_renlat')
            );
            $simpan = $this->model->add("osl", $data);
            if ($simpan == 1) {
                $status = "Data tersimpan";
            } else {
                $status = "Data gagal tersimpan";
            }
        }
        return $status;
    }

    public function ganti() {
        if (session()->get("logged_in")) {
            $kode = $this->request->uri->getSegment(3);
            $data = $this->model->getAllQR("SELECT *, 'Pemanasan' as model, idsimulator as sim FROM osp where idop_simulator = '" . $kode . "' 
                union 
                SELECT *, 'Latihan' as model, idsuratmasuk as sim FROM osl where idop_simulator = '" . $kode . "';");

            if ($data->model == "Latihan") {
                $suratmasuk = $this->model->getAllQR("SELECT idsuratmasuk, nosurat, idsimulator FROM suratmasuk where idsuratmasuk = '" . $data->sim . "';");
                // mencari nama simulator
                $simulator = $this->model->getAllQR("SELECT nama_simulator FROM simulator where idsimulator = '" . $suratmasuk->idsimulator . "';")->nama_simulator;
                $kode_renlat = $suratmasuk->idsuratmasuk;
                $nama_renlat = $simulator;
            } else {
                $kode_renlat = "";
                $nama_renlat = "";
            }

            echo json_encode(array(
                "kode" => $data->idop_simulator,
                "tanggal" => $data->tanggal,
                "kegiatan" => $data->kegiatan,
                "waktu_on" => $data->waktu_on,
                "waktu_off" => $data->waktu_off,
                "kondisi" => $data->kondisi,
                "keterangan" => $data->keterangan,
                "kode_renlat" => $kode_renlat,
                "nama_renlat" => $nama_renlat,
                "simulator" => $data->sim,
                "mode" => $data->model,
            ));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit() {
        if (session()->get("logged_in")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $status = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $status = $this->update_dengan();
                }
            } else {
                $status = $this->update_tanpa();
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function update_dengan() {
        $kode = $this->request->getPost('kode');
        $mode = $this->request->getPost('mode');
        if ($mode == "Pemanasan") {
            $lawas = $this->model->getAllQR("SELECT foto FROM osp where idop_simulator = '$kode';")->foto;
            if (strlen($lawas) > 0) {
                if (file_exists($this->modul->getPathApp() . $lawas)) {
                    unlink($this->modul->getPathApp() . $lawas);
                }
            }

            $file = $this->request->getFile('file');
            $namaFile = $file->getRandomName();
            $info_file = $this->modul->info_file($file);

            if (file_exists($this->modul->getPathApp() . $namaFile)) {
                $status = "Gunakan nama file lain";
            } else {
                $status_upload = $file->move($this->modul->getPathApp(), $namaFile);
                if ($status_upload) {
                    $data = array(
                        'tanggal' => $this->request->getPost('tanggal'),
                        'kegiatan' => $this->request->getPost('kegiatan'),
                        'waktu_on' => $this->request->getPost('waktuon'),
                        'waktu_off' => $this->request->getPost('waktuoff'),
                        'kondisi' => $this->request->getPost('kondisi'),
                        'keterangan' => $this->request->getPost('keterangan'),
                        'idsimulator' => $this->request->getPost('simulator'),
                        'foto' => $namaFile
                    );
                    $kond['idop_simulator'] = $kode;
                    $simpan = $this->model->update("osp", $data, $kond);
                    if ($simpan == 1) {
                        $status = "Data terupdate";
                    } else {
                        $status = "Data gagal terupdate";
                    }
                } else {
                    $status = "File gagal terupload";
                }
            }
        } else if ($mode == "Latihan") {
            $lawas = $this->model->getAllQR("SELECT foto FROM osl where idop_simulator = '$kode';")->foto;
            if (strlen($lawas) > 0) {
                if (file_exists($this->modul->getPathApp() . $lawas)) {
                    unlink($this->modul->getPathApp() . $lawas);
                }
            }

            $file = $this->request->getFile('file');
            $namaFile = $file->getRandomName();
            $info_file = $this->modul->info_file($file);

            if (file_exists($this->modul->getPathApp() . $namaFile)) {
                $status = "Gunakan nama file lain";
            } else {
                $status_upload = $file->move($this->modul->getPathApp(), $namaFile);
                $status = $status_upload;
                if ($status_upload) {
                    $data = array(
                        'tanggal' => $this->request->getPost('tanggal'),
                        'kegiatan' => $this->request->getPost('kegiatan'),
                        'waktu_on' => $this->request->getPost('waktuon'),
                        'waktu_off' => $this->request->getPost('waktuoff'),
                        'kondisi' => $this->request->getPost('kondisi'),
                        'keterangan' => $this->request->getPost('keterangan'),
                        'foto' => $namaFile,
                        'idsuratmasuk' => $this->request->getPost('kode_renlat')
                    );
                    $kond['idop_simulator'] = $kode;
                    $simpan = $this->model->update("osl", $data, $kond);
                    if ($simpan == 1) {
                        $status = "Data terupdate";
                    } else {
                        $status = "Data gagal terupdate";
                    }
                } else {
                    $status = "File gagal terupload";
                }
            }
        }
        return $status;
    }

    private function update_tanpa() {
        $mode = $this->request->getPost('mode');
        if ($mode == "Pemanasan") {
            $data = array(
                'tanggal' => $this->request->getPost('tanggal'),
                'kegiatan' => $this->request->getPost('kegiatan'),
                'waktu_on' => $this->request->getPost('waktuon'),
                'waktu_off' => $this->request->getPost('waktuoff'),
                'kondisi' => $this->request->getPost('kondisi'),
                'keterangan' => $this->request->getPost('keterangan'),
                'idsimulator' => $this->request->getPost('simulator'),
            );
            $kond['idop_simulator'] = $this->request->getPost('kode');
            $simpan = $this->model->update("osp", $data, $kond);
            if ($simpan == 1) {
                $status = "Data terupdate";
            } else {
                $status = "Data gagal terupdate";
            }
        } else if ($mode == "Latihan") {
            $data = array(
                'tanggal' => $this->request->getPost('tanggal'),
                'kegiatan' => $this->request->getPost('kegiatan'),
                'waktu_on' => $this->request->getPost('waktuon'),
                'waktu_off' => $this->request->getPost('waktuoff'),
                'kondisi' => $this->request->getPost('kondisi'),
                'keterangan' => $this->request->getPost('keterangan'),
                'idsuratmasuk' => $this->request->getPost('kode_renlat')
            );
            $kond['idop_simulator'] = $this->request->getPost('kode');
            $simpan = $this->model->update("osl", $data, $kond);
            if ($simpan == 1) {
                $status = "Data terupdate";
            } else {
                $status = "Data gagal terupdate";
            }
        }
        return $status;
    }

    public function hapus() {
        if (session()->get("logged_in")) {
            $idop_simulator = $this->request->uri->getSegment(3);
            $mode = $this->request->uri->getSegment(4);
            if ($mode == "Pemanasan") {
                $lawas = $this->model->getAllQR("SELECT foto FROM osp where idop_simulator = '$idop_simulator';")->foto;
                if (strlen($lawas) > 0) {
                    if (file_exists($this->modul->getPathApp() . $lawas)) {
                        unlink($this->modul->getPathApp() . $lawas);
                    }
                }

                $kond['idop_simulator'] = $idop_simulator;
                $hapus = $this->model->delete("osp", $kond);
                if ($hapus == 1) {
                    $status = "Data terhapus";
                } else {
                    $status = "Data gagal terhapus";
                }
            } else if ($mode == "Latihan") {
                $lawas = $this->model->getAllQR("SELECT foto FROM osl where idop_simulator = '$idop_simulator';")->foto;
                if (strlen($lawas) > 0) {
                    if (file_exists($this->modul->getPathApp() . $lawas)) {
                        unlink($this->modul->getPathApp() . $lawas);
                    }
                }

                $kond['idop_simulator'] = $idop_simulator;
                $hapus = $this->model->delete("osl", $kond);
                if ($hapus == 1) {
                    $status = "Data terhapus";
                } else {
                    $status = "Data gagal terhapus";
                }
            }

            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

}
