<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Ssh extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }
    
    public function index(){
        if(session()->get("logged_in")){
            $data['username'] = session()->get("username");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nmrole'] = $this->model->getAllQR("SELECT nama_role FROM role where idrole = '".$data['role']."';")->nama_role;
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.png';
            $pro_tersimpan = $this->model->getAllQR("select * from users where idusers = '".session()->get("username")."';");
            if(strlen($pro_tersimpan->foto) > 0){
                if(file_exists($this->modul->getPathApp().$pro_tersimpan->foto)){
                    $def_foto = base_url().'/uploads/'.$pro_tersimpan->foto;
                }
            }
            $data['foto_profile'] = $def_foto;;
            
            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml_identitas > 0){
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $deflogo = base_url().'/images/noimg.png';
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($this->modul->getPathApp().$tersimpan->logo)){
                        $deflogo = base_url().'/uploads/'.$tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
                
            }else{
                $data['logo'] = base_url().'/images/noimg.png';
            }
            
            $data['curdate'] = $this->modul->TanggalSekarang();
            $data['sakit'] = $this->model->getAllQ("select b.idsakit, a.nama_simulator from simulator a, sakit b where a.idsimulator = b.simulator;");

            echo view('head', $data);
            echo view('menu');
            echo view('sakit_harsis/index');
            echo view('foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if(session()->get("logged_in")){
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT a.*, b.simulator, date_format(a.tanggal, '%d %M %Y') as tgl FROM sakit_harsis a, sakit b where a.idsakit = b.idsakit order by a.tanggal;");
            foreach ($list->getResult() as $row) {
                $val = array();
                
                $deflogo = base_url().'/images/noimg.png';
                if(strlen($row->foto) > 0){
                    if(file_exists($this->modul->getPathApp().$row->foto)){
                        $deflogo = base_url().'/uploads/'.$row->foto;
                    }
                }
                $val[] = $no;
                $val[] = '<img src="'.$deflogo.'" class="img-thumbnail" style="width: 50px; height: auto;">';
                $val[] = $this->model->getAllQR("select b.idsakit, a.nama_simulator from simulator a, sakit b where a.idsimulator = b.simulator and b.idsakit = '".$row->idsakit."';")->nama_simulator;
                $val[] = $row->tgl;
                $val[] = $row->kerusakan;
                $val[] = $row->tindakan;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idsakit_harsis."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idsakit_harsis."'".','."'".$no."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->simpan_dengan();
                }
            }else{
                $status = $this->simpan_tanpa();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan_dengan() {
        $idusers = session()->get("username");
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists($this->modul->getPathApp().$namaFile)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move($this->modul->getPathApp(), $namaFile);
            if($status_upload){
                $data = array(
                    'idsakit_harsis' => $this->model->autokode("H","idsakit_harsis","sakit_harsis", 2, 7),
                    'tanggal' => $this->request->getPost('tgl'),
                    'idsakit' => $this->request->getPost('idsakit'),
                    'kerusakan' => $this->request->getPost('kerusakan'),
                    'tindakan' => $this->request->getPost('tindakan'),
                    'keterangan' => $this->request->getPost('keterangan'),
                    'foto' => $namaFile,
                    'idusers' => $idusers
                );
                $simpan = $this->model->add("sakit_harsis",$data);
                if($simpan == 1){
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function simpan_tanpa() {
        $idusers = session()->get("username");
        $data = array(
            'idsakit_harsis' => $this->model->autokode("H","idsakit_harsis","sakit_harsis", 2, 7),
            'tanggal' => $this->request->getPost('tgl'),
            'idsakit' => $this->request->getPost('idsakit'),
            'kerusakan' => $this->request->getPost('kerusakan'),
            'tindakan' => $this->request->getPost('tindakan'),
            'keterangan' => $this->request->getPost('keterangan'),
            'foto' => '',
            'idusers' => $idusers
        );
        $simpan = $this->model->add("sakit_harsis",$data);
        if($simpan == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    public function ganti(){
        if(session()->get("logged_in")){
            $kond['idkorps'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("korps", $kond);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_in")){
            $data = array(
                'nama_korps' => $this->request->getPost('nama')
            );
            $kond['idkorps'] = $this->request->getPost('kode');
            $update = $this->model->update("korps",$data, $kond);
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if(session()->get("logged_in")){
            $kond['idkorps'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("korps",$kond);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
