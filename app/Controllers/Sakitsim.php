<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Sakitsim extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_in")){
            $data['username'] = session()->get("username");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            
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
            
            echo view('head', $data);
            echo view('menu');
            echo view('sakit/index');
            echo view('foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if(session()->get("logged_in")){
            $no = 1;
            $data = array();
            $list = $this->model->getAll("sakit");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $deflogo = base_url().'/images/noimg.png';
                if(strlen($row->foto) > 0){
                    if(file_exists($this->modul->getPathApp().$row->foto)){
                        $deflogo = base_url().'/uploads/'.$row->foto;
                    }
                }
                $val[] = '<img src="'.$deflogo.'" class="img-thumbnail" style="width: 50px; height: auto;">';
                $val[] = $this->model->getAllQR("SELECT nama_simulator FROM simulator where idsimulator = '".$row->simulator."';")->nama_simulator;
                $val[] = $row->nama_barang;
                $val[] = $row->gejala;
                $val[] = $row->kegiatan;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idsakit."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idsakit."'".','."'".$no."'".')">Hapus</button>'
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
    
    public function load_sim() {
        if(session()->get("logged_in")){
            $mode = $this->request->uri->getSegment(3);
            $status = '<option value="-">- PILIH SIMULATOR -</option>';
            if($mode == "Pemanasan"){
                $list = $this->model->getAllQ("SELECT a.idsimulator, a.idop_simulator, b.nama_simulator, date_format(a.tanggal, '%d %M %Y') as tgl, a.kegiatan FROM osp a, simulator b where a.idsimulator = b.idsimulator;");
                foreach ($list->getResult() as $row) {
                    $status .= '<option value="'.$row->idsimulator.'-'.$row->idop_simulator.'">'.$row->nama_simulator.' '.'( '.$row->tgl.' - '. $row->kegiatan .' )'.'</option>';
                }
            }else if($mode == "Latihan"){
                $list = $this->model->getAllQ("select c.idsimulator, a.idop_simulator, c.nama_simulator, date_format(a.tanggal, '%d %M %Y') as tgl, a.kegiatan from osl a, suratmasuk b, simulator c where a.idsuratmasuk = b.idsuratmasuk and b.idsimulator = c.idsimulator;");
                foreach ($list->getResult() as $row) {
                    $status .= '<option value="'.$row->idsimulator.'-'.$row->idop_simulator.'">'.$row->nama_simulator.' '.'( '.$row->tgl.' - '. $row->kegiatan .' )'.'</option>';
                }
            }else if($mode == "Sakit"){
                $list = $this->model->getAll("simulator");
                foreach ($list->getResult() as $row) {
                    $status .= '<option value="'.$row->idsimulator.'">'.$row->nama_simulator.'</option>';
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function load_sim1() {
        if(session()->get("logged_in")){
            $mode = $this->request->uri->getSegment(3);
            $kode = $this->request->uri->getSegment(4);
            
            $status = '<option value="-">- PILIH SIMULATOR -</option>';
            
            if($mode == "Pemanasan"){    
                $list = $this->model->getAllQ("SELECT a.idsimulator, a.idop_simulator, b.nama_simulator, date_format(a.tanggal, '%d %M %Y') as tgl, a.kegiatan FROM osp a, simulator b where a.idsimulator = b.idsimulator;");
                foreach ($list->getResult() as $row) {
                    if($row->idop_simulator == $kode){
                        $status .= '<option selected value="'.$row->idsimulator.'-'.$row->idop_simulator.'">'.$row->nama_simulator.' '.'( '.$row->tgl.' - '. $row->kegiatan .' )'.'</option>';
                    }else{
                        $status .= '<option value="'.$row->idsimulator.'-'.$row->idop_simulator.'">'.$row->nama_simulator.' '.'( '.$row->tgl.' - '. $row->kegiatan .' )'.'</option>';
                    }
                }
            }else if($mode == "Latihan"){
                $list = $this->model->getAllQ("select c.idsimulator, a.idop_simulator, c.nama_simulator, date_format(a.tanggal, '%d %M %Y') as tgl, a.kegiatan from osl a, suratmasuk b, simulator c where a.idsuratmasuk = b.idsuratmasuk and b.idsimulator = c.idsimulator;");
                foreach ($list->getResult() as $row) {
                    if($row->idop_simulator == $kode){
                        $status .= '<option selected value="'.$row->idsimulator.'-'.$row->idop_simulator.'">'.$row->nama_simulator.' '.'( '.$row->tgl.' - '. $row->kegiatan .' )'.'</option>';
                    }else{
                        $status .= '<option value="'.$row->idsimulator.'-'.$row->idop_simulator.'">'.$row->nama_simulator.' '.'( '.$row->tgl.' - '. $row->kegiatan .' )'.'</option>';
                    }
                }
            }else if($mode == "Sakit"){
                $list = $this->model->getAll("simulator");
                foreach ($list->getResult() as $row) {
                    if($row->idsimulator == $kode){
                        $status .= '<option selected value="'.$row->idsimulator.'">'.$row->nama_simulator.'</option>';
                    }else{
                        $status .= '<option value="'.$row->idsimulator.'">'.$row->nama_simulator.'</option>';
                    }
                    
                }
            }
            
            echo json_encode(array("status" => $status));
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
                $mode = $this->request->getPost('mode');
                if($mode == "Pemanasan"){
                    $mentah = explode("-", $this->request->getPost('sim'));
                    $sim = $mentah[0];
                    $kode_rujukan = $mentah[1];
                }else if($mode == "Latihan"){
                    $mentah = explode("-", $this->request->getPost('sim'));
                    $sim = $mentah[0];
                    $kode_rujukan = $mentah[1];
                }else if($mode == "Sakit"){
                    $sim = $this->request->getPost('sim');
                    $kode_rujukan = "";
                }
                
                $data = array(
                    'idsakit' => $this->model->autokode('S','idsakit', 'sakit', 2, 7),
                    'simulator' => $sim,
                    'model' => $this->request->getPost('mode'),
                    'nama_barang' => $this->request->getPost('nama'),
                    'gejala' => $this->request->getPost('gejala'),
                    'kegiatan' => $this->request->getPost('kegiatan'),
                    'keterangan' => $this->request->getPost('keterangan'),
                    'foto' => $namaFile,
                    'idusers' => $idusers,
                    'tanggal' => $this->request->getPost('tanggal'),
                    'kd_rujukan' => $kode_rujukan
                );
                $simpan = $this->model->add("sakit",$data);
                if($simpan == 1){
                    $status = "Date tersimpan";
                }else{
                    $status = "Date gagal tersimpan";
                }
            }else{
                $status = "File gagal terupload";
            }
        }   
        return $status;
    }
    
    private function simpan_tanpa() {
        $idusers = session()->get("username");
        $mode = $this->request->getPost('mode');
        if($mode == "Pemanasan"){
            $mentah = explode("-", $this->request->getPost('sim'));
            $sim = $mentah[0];
            $kode_rujukan = $mentah[1];
        }else if($mode == "Latihan"){
            $mentah = explode("-", $this->request->getPost('sim'));
            $sim = $mentah[0];
            $kode_rujukan = $mentah[1];
        }else if($mode == "Sakit"){
            $sim = $this->request->getPost('sim');
            $kode_rujukan = "";
        }
                
        $data = array(
            'idsakit' => $this->model->autokode('S','idsakit', 'sakit', 2, 7),
            'simulator' => $sim,
            'model' => $this->request->getPost('mode'),
            'nama_barang' => $this->request->getPost('nama'),
            'gejala' => $this->request->getPost('gejala'),
            'kegiatan' => $this->request->getPost('kegiatan'),
            'keterangan' => $this->request->getPost('keterangan'),
            'foto' => '',
            'idusers' => $idusers,
            'tanggal' => $this->request->getPost('tanggal'),
            'kd_rujukan' => $kode_rujukan
        );
        $simpan = $this->model->add("sakit",$data);
        if($simpan == 1){
            $status = "Date tersimpan";
        }else{
            $status = "Date gagal tersimpan";
        }
        
        return $status;
    }
    
    public function ganti(){
        if(session()->get("logged_in")){
            $kond['idsakit'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("sakit", $kond);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->update_dengan();
                }
            }else{
                $status = $this->update_tanpa();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function update_dengan() {
        $kode = $this->request->getPost('kode');
        $logo = $this->model->getAllQR("SELECT foto FROM sakit where idsakit = '".$kode."';")->foto;
        if(strlen($logo) > 0){
            if(file_exists($this->modul->getPathApp().$logo)){
                unlink($this->modul->getPathApp().$logo); 
            }
        }
        
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists($this->modul->getPathApp().$namaFile)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move($this->modul->getPathApp(), $namaFile);
            if($status_upload){
                $mode = $this->request->getPost('mode');
                if($mode == "Pemanasan"){
                    $mentah = explode("-", $this->request->getPost('sim'));
                    $sim = $mentah[0];
                    $kode_rujukan = $mentah[1];
                }else if($mode == "Latihan"){
                    $mentah = explode("-", $this->request->getPost('sim'));
                    $sim = $mentah[0];
                    $kode_rujukan = $mentah[1];
                }else if($mode == "Sakit"){
                    $sim = $this->request->getPost('sim');
                    $kode_rujukan = "";
                }

                $data = array(
                    'simulator' => $sim,
                    'model' => $this->request->getPost('mode'),
                    'nama_barang' => $this->request->getPost('nama'),
                    'gejala' => $this->request->getPost('gejala'),
                    'kegiatan' => $this->request->getPost('kegiatan'),
                    'keterangan' => $this->request->getPost('keterangan'),
                    'foto' => $namaFile,
                    'tanggal' => $this->request->getPost('tanggal'),
                    'kd_rujukan' => $kode_rujukan
                );
                $kond['idsakit'] = $kode;
                $simpan = $this->model->update("sakit", $data, $kond);
                if($simpan == 1){
                    $status = "Date terupdate";
                }else{
                    $status = "Date gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }   
        return $status;
    }
    
    private function update_tanpa() {
        $mode = $this->request->getPost('mode');
        if($mode == "Pemanasan"){
            $mentah = explode("-", $this->request->getPost('sim'));
            $sim = $mentah[0];
            $kode_rujukan = $mentah[1];
        }else if($mode == "Latihan"){
            $mentah = explode("-", $this->request->getPost('sim'));
            $sim = $mentah[0];
            $kode_rujukan = $mentah[1];
        }else if($mode == "Sakit"){
            $sim = $this->request->getPost('sim');
            $kode_rujukan = "";
        }
        
        $data = array(
            'simulator' => $sim,
            'model' => $this->request->getPost('mode'),
            'nama_barang' => $this->request->getPost('nama'),
            'gejala' => $this->request->getPost('gejala'),
            'kegiatan' => $this->request->getPost('kegiatan'),
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'kd_rujukan' => $kode_rujukan
        );
        $kond['idsakit'] = $this->request->getPost('kode');
        $simpan = $this->model->update("sakit",$data, $kond);
        if($simpan == 1){
            $status = "Date terupdate";
        }else{
            $status = "Date gagal terupdate";
        }
        return $status;
    }
    
    public function hapus() {
        if(session()->get("logged_in")){
            $kode = $this->request->uri->getSegment(3);
            $logo = $this->model->getAllQR("SELECT foto FROM sakit where idsakit = '".$kode."';")->foto;
            if(strlen($logo) > 0){
                if(file_exists($this->modul->getPathApp().$logo)){
                    unlink($this->modul->getPathApp().$logo); 
                }
            }
       
            $kond['idsakit'] = $kode;
            $hapus = $this->model->delete("sakit",$kond);
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
