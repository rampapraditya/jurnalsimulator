<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use Dompdf\Dompdf;
use Dompdf\Options;

class Sshnon extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }
    
    public function index(){
        if(session()->get("logged_no_admin")){
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
            
            echo view('head_non', $data);
            echo view('menu_non');
            echo view('sakit_harsis_non/index');
            echo view('foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if(session()->get("logged_no_admin")){
            $role = session()->get("role");
            $nmrole = $this->model->getAllQR("SELECT nama_role FROM role where idrole = '".$role."';")->nama_role;
            
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
                if($row->ver == 1){
                    $val[] = "Terverifikasi";
                }else{
                    $val[] = "Belum Terverifikasi";
                }
                
                if($nmrole == "KOMANDAN" || $nmrole == "WADAN"){
                    $val[] = '<div style="text-align: center;"></div>';
                }else{
                    $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idsakit_harsis."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idsakit_harsis."'".','."'".$no."'".')">Hapus</button>'
                        . '</div>';
                }
                
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxshowsakit() {
        if (session()->get("logged_no_admin")) {
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select b.idsakit, b.simulator, a.nama_simulator from simulator a, sakit b where a.idsimulator = b.simulator and b.idsakit not in(select idsakit from sakit_harsis);");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_simulator;
                $str = '<table class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>FOTO</th>
                                    <th>BARANG</th>
                                    <th>GEJAJA</th>
                                    <th>KEGIATAN</th>
                                </tr>
                            </thead>
                            <tbody>';
                $list1 = $this->model->getAllQ("SELECT * FROM sakit_detil where idsakit = '".$row->idsakit."';");
                foreach ($list1->getResult() as $row1) {
                    $str .= '<tr>';
                    $defimg = base_url() . '/images/noimg.png';
                    if (strlen($row1->foto) > 0) {
                        if (file_exists($this->modul->getPathApp().$row1->foto)) {
                            $defimg = base_url().'/uploads/'.$row1->foto;
                        }
                    }
                    $str .= '<td><img src="'.$defimg.'" class="img-thumbnail" style="width: 50px; height: auto;"></td>';
                    $str .= '<td>'.$row1->nama_barang.'</td>';
                    $str .= '<td>'.$row1->gejala.'</td>';
                    $str .= '<td>'.$row1->kegiatan.'</td>';
                    $str .= '</tr>';
                }
                $str .= '</tbody></table>';
                $val[] = $str;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-info btn-fw" onclick="pilih('."'".$row->idsakit."'".','."'".$row->nama_simulator."'".')">Pilih</button>'
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
        if(session()->get("logged_no_admin")){
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
        if(session()->get("logged_no_admin")){
            $idsakit_harsis = $this->request->uri->getSegment(3);
            $data = $this->model->getAllQR("select c.*, b.idsakit, b.simulator, a.nama_simulator from simulator a, sakit b, sakit_harsis c where a.idsimulator = b.simulator and b.idsakit = c.idsakit and c.idsakit_harsis = '".$idsakit_harsis."';");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_no_admin")){
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
        $idusers = session()->get("username");
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists($this->modul->getPathApp().$namaFile)){
            $status = "Gunakan nama file lain";
        }else{
            
            $logo = $this->model->getAllQR("SELECT foto FROM sakit_harsis where idsakit_harsis = '".$this->request->getPost('kode')."';")->foto;
            if(strlen($logo) > 0){
                if(file_exists($this->modul->getPathApp().$logo)){
                    unlink($this->modul->getPathApp().$logo); 
                }
            }
        
            $status_upload = $file->move($this->modul->getPathApp(), $namaFile);
            if($status_upload){
                $data = array(
                    'tanggal' => $this->request->getPost('tgl'),
                    'idsakit' => $this->request->getPost('idsakit'),
                    'kerusakan' => $this->request->getPost('kerusakan'),
                    'tindakan' => $this->request->getPost('tindakan'),
                    'keterangan' => $this->request->getPost('keterangan'),
                    'foto' => $namaFile,
                    'idusers' => $idusers
                );
                $kond['idsakit_harsis'] = $this->request->getPost('kode');
                $simpan = $this->model->update("sakit_harsis",$data, $kond);
                if($simpan == 1){
                    $status = "Data terupdate";
                }else{
                    $status = "Data gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function update_tanpa() {
        $idusers = session()->get("username");
        $data = array(
            'tanggal' => $this->request->getPost('tgl'),
            'idsakit' => $this->request->getPost('idsakit'),
            'kerusakan' => $this->request->getPost('kerusakan'),
            'tindakan' => $this->request->getPost('tindakan'),
            'keterangan' => $this->request->getPost('keterangan'),
            'idusers' => $idusers
        );
        $kond['idsakit_harsis'] = $this->request->getPost('kode');
        $simpan = $this->model->update("sakit_harsis",$data, $kond);
        if($simpan == 1){
            $status = "Data terupdate";
        }else{
            $status = "Data gagal terupdate";
        }
        return $status;
    }

    public function hapus() {
        if(session()->get("logged_no_admin")){
            $kode = $this->request->uri->getSegment(3);
            $logo = $this->model->getAllQR("SELECT foto FROM sakit_harsis where idsakit_harsis = '".$kode."';")->foto;
            if(strlen($logo) > 0){
                if(file_exists($this->modul->getPathApp().$logo)){
                    unlink($this->modul->getPathApp().$logo); 
                }
            }
            $kond['idsakit_harsis'] = $kode;
            $hapus = $this->model->delete("sakit_harsis",$kond);
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
    
    public function cetak(){
        if(session()->get("logged_no_admin")){
            $tgl1 = $this->request->uri->getSegment(3);
            $tgl2 = $this->request->uri->getSegment(4);
            
            $data['tgl1'] = $this->model->getAllQR("select date_format('".$tgl1."', '%d %M %Y') as tgl;")->tgl;
            $data['tgl2'] = $this->model->getAllQR("select date_format('".$tgl2."', '%d %M %Y') as tgl;")->tgl;
            $data['list'] = $this->model->getAllQ("SELECT a.*, b.simulator, date_format(a.tanggal, '%d %M %Y') as tgl FROM sakit_harsis a, sakit b where a.idsakit = b.idsakit and a.tanggal between '".$tgl1."' and '".$tgl2."' order by a.tanggal;");
            $data['modul'] = $this->modul;
            $data['model'] = $this->model;
            
            $options = new Options();
            $options->setChroot(FCPATH);
            $dompdf = new Dompdf();
            $dompdf->setOptions($options);
            $dompdf->loadHtml(view('sakit_harsis_non/pdf', $data));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $filename = 'JURNAL_SAKIT_HARSIS';
            $dompdf->stream($filename); 
        }else{
            $this->modul->halaman('login');
        }
    }
}
