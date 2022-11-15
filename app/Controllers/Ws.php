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
                    $def_foto = base_url() . '/images/noimg.png';
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
        $kond['idusers'] = $this->request->getPost('idusers');
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

    public function simpanprofile_file() {
        $dir = $this->modul->setPathApp();
        $idusers = $this->request->getPost('idusers');

        if (isset($_FILES['image']['name'])) {
            $file_name_temp = basename($_FILES['image']['name']);
            $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $file_name_temp);
            $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
                if ($_FILES["image"]["size"] < 4000001) {
                    $file = $dir . $file_name;

                    // hapus file jika ada yang lama
                    $lawas = $this->model->getAllQR("SELECT foto FROM users where idusers = '" . $idusers . "';")->foto;
                    if (strlen($lawas) > 0) {
                        if (file_exists($this->modul->getPathApp() . $lawas)) {
                            unlink($this->modul->getPathApp() . $lawas);
                        }
                    }

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $file)) {
                        $data = array(
                            'nrp' => $this->request->getPost('nrp'),
                            'nama' => $this->request->getPost('nama'),
                            'idkorps' => $this->request->getPost('korps'),
                            'idpangkat' => $this->request->getPost('pangkat'),
                            'foto' => $file_name
                        );
                        $kond['idusers'] = $this->request->getPost('idusers');
                        $update = $this->model->update("users", $data, $kond);
                        if ($update == 1) {
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

        $def_foto = base_url() . '/images/noimg.png';
        $baru = $this->model->getAllQR("SELECT foto FROM users where idusers = '" . $idusers . "';")->foto;
        if (strlen($baru) > 0) {
            if (file_exists($this->modul->getPathApp() . $baru)) {
                $def_foto = base_url() . '/uploads/' . $baru;
            }
        }

        $result = array();
        array_push($result, array('status' => $status, 'foto' => $def_foto));
        echo json_encode(array("result" => $result));
    }

    public function personil() {
        $idrole = $this->request->getPost('idrole');

        // mencari yang role nya sama
        $result = array();
        $list = $this->model->getAllQ("select a.idusers, c.nama_pangkat, d.nama_korps, a.nama, a.nrp, a.iddivisi, a.idjabatan from users a, role b, pangkat c, korps d where a.idrole = b.idrole and a.idpangkat = c.idpangkat and a.idkorps = d.idkorps and b.idrole = '" . $idrole . "';");
        foreach ($list->getResult() as $row) {
            if (strlen($row->iddivisi) > 0 && $row->iddivisi <> "-") {
                $divisi = $this->model->getAllQR("select nama_divisi from divisi where iddivisi = '" . $row->iddivisi . "';")->nama_divisi;
            } else {
                $divisi = "";
            }
            if (strlen($row->idjabatan) > 0 && $row->idjabatan <> "-") {
                $jabatan = $this->model->getAllQR("select nama_jabatan from jabatan where idjabatan = '" . $row->idjabatan . "';")->nama_jabatan;
            } else {
                $jabatan = "";
            }

            array_push($result, array(
                'idusers' => $row->idusers,
                'pangkat' => $row->nama_pangkat,
                'korps' => $row->nama_korps,
                'nama' => $row->nama,
                'nrp' => $row->nrp,
                'divisi' => $divisi,
                'jabatan' => $jabatan
            ));
        }
        echo json_encode(array("result" => $result));
    }

    public function data_renlat() {
        $result = array();
        $no = 1;
        $list = $this->model->getAllQ("SELECT suratmasuk.*, users.nrp, users.nama, simulator.nama_simulator, date_format(tanggal, '%d %M %Y') as tgl, 
		year(tanggal) as thn, month(tanggal) as bln, day(tanggal) as hari FROM suratmasuk 
		LEFT JOIN users ON suratmasuk.idusers = users.idusers 
		LEFT JOIN simulator ON suratmasuk.idsimulator = simulator.idsimulator");
        foreach ($list->getResult() as $row) {
            array_push($result, array(
                'no' => $no,
                'idsuratmasuk' => $row->idsuratmasuk,
                'nama_simulator' => $row->nama_simulator,
                'tanggal' => $row->tgl,
                'nosurat' => $row->nosurat,
                'dari' => $row->dari,
                'perihal' => $row->perihal,
                'keterangan' => $row->keterangan,
                'mode' => $row->mode,
                'tahun' => $row->thn,
                'bulan' => $row->bln,
                'hari' => $row->hari
            ));
            $no++;
        }
        echo json_encode(array("result" => $result));
    }

    public function data_renlat_by_date() {
        $tgl = $this->request->getPost('tanggal');

        $result = array();
        $no = 1;
        $list = $this->model->getAllQ("SELECT suratmasuk.*, users.nrp, users.nama, simulator.nama_simulator, date_format(tanggal, '%d %M %Y') as tgl,
			year(tanggal) as thn, month(tanggal) as bln, day(tanggal) as hari FROM suratmasuk
			LEFT JOIN users ON suratmasuk.idusers = users.idusers
			LEFT JOIN simulator ON suratmasuk.idsimulator = simulator.idsimulator where tanggal = '" . $tgl . "';");
        foreach ($list->getResult() as $row) {
            array_push($result, array(
                'no' => $no,
                'idsuratmasuk' => $row->idsuratmasuk,
                'nama_simulator' => $row->nama_simulator,
                'tanggal' => $row->tgl,
                'nosurat' => $row->nosurat,
                'dari' => $row->dari,
                'perihal' => $row->perihal,
                'keterangan' => $row->keterangan,
                'mode' => $row->mode,
                'tahun' => $row->thn,
                'bulan' => $row->bln,
                'hari' => $row->hari
            ));
            $no++;
        }
        echo json_encode(array("result" => $result));
    }

    public function alat_sim() {
        $result = array();
        $list = $this->model->getAll("simulator");
        foreach ($list->getResult() as $row) {
            array_push($result, array(
                'idsim' => $row->idsimulator,
                'namasim' => $row->nama_simulator,
                'letak' => $row->letak,
                'tahun' => $row->tahun
            ));
        }
        echo json_encode(array("result" => $result));
    }

    public function tambah_renlat() {
        $data = array(
            'idsuratmasuk' => $this->model->autokode("S", "idsuratmasuk", "suratmasuk", 2, 7),
            'idusers' => $this->request->getPost('idusers'),
            'idsimulator' => $this->request->getPost('kode_sim'),
            'tanggal' => $this->request->getPost('tanggal'),
            'nosurat' => $this->request->getPost('nosurat'),
            'dari' => $this->request->getPost('dari'),
            'perihal' => $this->request->getPost('perihal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'mode' => $this->request->getPost('mode')
        );
        $simpan = $this->model->add("suratmasuk", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }

        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }

    public function ganti_renlat() {
        $data = array(
            'idsimulator' => $this->request->getPost('kode_sim'),
            'tanggal' => $this->request->getPost('tanggal'),
            'nosurat' => $this->request->getPost('nosurat'),
            'dari' => $this->request->getPost('dari'),
            'perihal' => $this->request->getPost('perihal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'mode' => $this->request->getPost('mode')
        );
        $kond['idsuratmasuk'] = $this->request->getPost('kode');
        $update = $this->model->update("suratmasuk", $data, $kond);
        if ($update == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }

    public function hapus_renlat() {
        $kond['idsuratmasuk'] = $this->request->getPost('kode');
        $hapus = $this->model->delete("suratmasuk", $kond);
        if ($hapus == 1) {
            $status = "Data terhapus";
        } else {
            $status = "Data gagal terhapus";
        }
        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }

    public function data_opslat() {
        $result = array();
        $no = 1;
        $list = $this->model->getAllQ("SELECT *, 'Pemanasan' as model, idsimulator as idsuratmasuk FROM osp 
                union 
                SELECT *, 'Latihan' as model, idsuratmasuk FROM osl order by tanggal desc;");
        foreach ($list->getResult() as $row) {
            $val[] = $no;

            $deflogo = base_url() . '/images/noimg.png';
            if (strlen($row->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $row->foto)) {
                    $deflogo = base_url() . '/uploads/' . $row->foto;
                }
            }
            if ($row->model == "Pemanasan") {
                $nama_sim = $this->model->getAllQR("SELECT nama_simulator FROM simulator where idsimulator = '" . $row->idsuratmasuk . "';")->nama_simulator;
            } else if ($row->model == "Latihan") {
                $cek1 = $this->model->getAllQR("SELECT count(b.nama_simulator) as jml FROM suratmasuk a, simulator b where a.idsimulator = b.idsimulator and a.idsuratmasuk = '" . $row->idsuratmasuk . "';")->jml;
                if ($cek1 > 0) {
                    $nama_sim = $this->model->getAllQR("SELECT b.nama_simulator FROM suratmasuk a, simulator b where a.idsimulator = b.idsimulator and a.idsuratmasuk = '" . $row->idsuratmasuk . "';")->nama_simulator;
                } else {
                    $nama_sim = "";
                }
            }

            array_push($result, array(
                'no' => $no,
                'kode' => $row->idop_simulator,
                'idsim' => $row->idsuratmasuk,
                'namasim' => $nama_sim,
                'gambar' => $deflogo,
                'kegiatan' => $row->kegiatan,
                'tanggal' => $row->tanggal,
                'waktu_on' => $row->waktu_on,
                'waktu_off' => $row->waktu_off,
                'kondisi' => $row->kondisi,
                'model' => $row->model,
                'keterangan' => $row->keterangan
            ));
            $no++;
        }
        echo json_encode(array("result" => $result));
    }

    public function simpan_opslat_pemanasan() {
        $data = array(
            'idop_simulator' => $this->model->autokode("P", "idop_simulator", "osp", 2, 7),
            'tanggal' => $this->request->getPost('tanggal'),
            'kegiatan' => $this->request->getPost('kegiatan'),
            'waktu_on' => $this->request->getPost('waktuon'),
            'waktu_off' => $this->request->getPost('waktuoff'),
            'kondisi' => $this->request->getPost('kondisi'),
            'keterangan' => $this->request->getPost('keterangan'),
            'foto' => '',
            'idusers' => $this->request->getPost('idusers'),
            'idsimulator' => $this->request->getPost('simulator')
        );
        $simpan = $this->model->add("osp", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
    
    public function simpan_opslat_latihan() {
        $data = array(
            'idop_simulator' => $this->model->autokode("L", "idop_simulator", "osl", 2, 7),
            'tanggal' => $this->request->getPost('tanggal'),
            'kegiatan' => $this->request->getPost('kegiatan'),
            'waktu_on' => $this->request->getPost('waktuon'),
            'waktu_off' => $this->request->getPost('waktuoff'),
            'kondisi' => $this->request->getPost('kondisi'),
            'keterangan' => $this->request->getPost('keterangan'),
            'foto' => '',
            'idusers' => $this->request->getPost('idusers'),
            'idsuratmasuk' => $this->request->getPost('kode_renlat')
        );
        $simpan = $this->model->add("osl", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
    
    public function update_opslat_pemanasan() {
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
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
    
    public function update_opslat_latihan() {
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
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
    
    public function hapus_opslat() {
        $idop_simulator = $this->request->getPost('kode');
        $mode = $this->request->getPost('mode');
        if ($mode == "Pemanasan") {
            $lawas = $this->model->getAllQR("SELECT foto FROM osp where idop_simulator = '$idop_simulator';")->foto;
            if (strlen($lawas) > 0) {
                if (file_exists($this->modul->getPathApp().$lawas)) {
                    unlink($this->modul->getPathApp().$lawas);
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
        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
    
    public function simpan_opslat_file() {
        $dir = $this->modul->setPathApp();
        $idusers = $this->request->getPost('idusers');

        if (isset($_FILES['image']['name'])) {
            $file_name_temp = basename($_FILES['image']['name']);
            $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $file_name_temp);
            $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
                if ($_FILES["image"]["size"] < 4000001) {
                    $file = $dir . $file_name;

                    // hapus file jika ada yang lama
                    $lawas = $this->model->getAllQR("SELECT foto FROM users where idusers = '" . $idusers . "';")->foto;
                    if (strlen($lawas) > 0) {
                        if (file_exists($this->modul->getPathApp() . $lawas)) {
                            unlink($this->modul->getPathApp() . $lawas);
                        }
                    }

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $file)) {
                        $data = array(
                            'nrp' => $this->request->getPost('nrp'),
                            'nama' => $this->request->getPost('nama'),
                            'idkorps' => $this->request->getPost('korps'),
                            'idpangkat' => $this->request->getPost('pangkat'),
                            'foto' => $file_name
                        );
                        $kond['idusers'] = $this->request->getPost('idusers');
                        $update = $this->model->update("users", $data, $kond);
                        if ($update == 1) {
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
            $status = "Tanpa Foto";
        }

        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
    
    public function getsakitsim() {
        $result = array();
        $no = 1;
        $list = $this->model->getAllQ("select *, date_format(tanggal, '%d %M %Y') as tgl from sakit order by idsakit desc;");
        foreach ($list->getResult() as $row) {
            $nama_simulator = $this->model->getAllQR("SELECT nama_simulator FROM simulator where idsimulator = '" . $row->simulator . "';")->nama_simulator;
            array_push($result, array(
                'no' => $no,
                'idsakit' => $row->idsakit,
                'idsim' => $row->simulator,
                'namasim' => $nama_simulator,
                'tanggal' => $row->tanggal,
                'tglf' => $row->tgl,
            ));
            $no++;
        }
        echo json_encode(array("result" => $result));
    }
    
    public function getsakitsim_detil() {
        $idsakit = $this->request->getPost('idsakit');
        // load sakit
        $result = array();
        $list = $this->model->getAllQ("SELECT * FROM sakit_detil where idsakit = '" . $idsakit . "';");
        foreach ($list->getResult() as $row) {
            
            $defimg = base_url() . '/images/noimg.png';
            if (strlen($row1->foto) > 0) {
                if (file_exists($this->modul->getPathApp().$row->foto)) {
                    $defimg = base_url().'/uploads/'.$row->foto;
                }
            }
            
            array_push($result, array(
                'gambar' => $defimg,
                'namabarang' => $row->nama_barang,
                'gejala' => $row->gejala,
                'kegiatan' => $row->kegiatan
            ));
        }
        echo json_encode(array("result" => $result));
    }
    
    public function load_sakit_pemanasan() {
        $result = array();
        $list = $this->model->getAllQ("SELECT a.idsimulator, a.idop_simulator, b.nama_simulator, date_format(a.tanggal, '%d %M %Y') as tgl, a.kegiatan FROM osp a, simulator b where a.idsimulator = b.idsimulator;");
        foreach ($list->getResult() as $row) {
            array_push($result, array(
                'idsimulator' => $row->idsimulator,
                'idop_simulator' => $row->idop_simulator,
                'keterangan' => $row->nama_simulator . ' ' . '( ' . $row->tgl . ' - ' . $row->kegiatan . ' )'
            ));
        }
        echo json_encode(array("result" => $result));
    }
    
    public function load_sakit_latihan() {
        $result = array();
        $list = $this->model->getAllQ("select c.idsimulator, a.idop_simulator, c.nama_simulator, date_format(a.tanggal, '%d %M %Y') as tgl, a.kegiatan from osl a, suratmasuk b, simulator c where a.idsuratmasuk = b.idsuratmasuk and b.idsimulator = c.idsimulator;");
        foreach ($list->getResult() as $row) {
            array_push($result, array(
                'idsimulator' => $row->idsimulator,
                'idop_simulator' => $row->idop_simulator,
                'keterangan' => $row->nama_simulator . ' ' . '( ' . $row->tgl . ' - ' . $row->kegiatan . ' )'
            ));
        }
        echo json_encode(array("result" => $result));
    }
    
    public function load_sakit_simulator() {
        $result = array();
        $list = $this->model->getAll("simulator");
        foreach ($list->getResult() as $row) {
            array_push($result, array(
                'idsimulator' => $row->idsimulator,
                'keterangan' => $row->nama_simulator
            ));
        }
        echo json_encode(array("result" => $result));
    }
    
    public function simpan_sakit_simulator_head() {
        $data = array(
            'idsakit' => $this->model->autokode('S', 'idsakit', 'sakit', 2, 7),
            'simulator' => $this->request->getPost('idsim'),
            'model' => $this->request->getPost('model'),
            'idusers' => $this->request->getPost('idusers'),
            'tanggal' => $this->request->getPost('tanggal'),
            'kd_rujukan' => $this->request->getPost('koderujukan')
        );
        $simpan = $this->model->add("sakit", $data);
        if ($simpan == 1) {
            $status = "Date tersimpan";
        } else {
            $status = "Date gagal tersimpan";
        }
        $result = array();
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
    
    public function load_sakit_sim_detil() {
        $idsakit = $this->request->getPost('idsakit');
        
        $result = array();
        $no = 1;
        $list = $this->model->getAllQ("SELECT * FROM sakit_detil where idsakit = '" . $idsakit . "';");
        foreach ($list->getResult() as $row) {
            $deflogo = base_url() . '/images/noimg.png';
            if (strlen($row->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $row->foto)) {
                    $deflogo = base_url() . '/uploads/' . $row->foto;
                }
            }
            array_push($result, array(
                'idsakit_detil' => $row->idsakit_detil,
                'no' => $no,
                'gambar' => $deflogo,
                'nama_barang' => $row->nama_barang,
                'gejala' => $row->gejala,
                'kegiatan' => $row->kegiatan,
                'keterangan' => $row->keterangan
            ));
            $no++;
        }
        echo json_encode(array("result" => $result));
    }
}
