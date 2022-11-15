<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use Dompdf\Dompdf;
use Dompdf\Options;

class Jhh extends BaseController {
    
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
            
            echo view('head', $data);
            echo view('menu');
            echo view('harwat_harsis/index');
            echo view('foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if(session()->get("logged_in")){
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT a.*, date_format(a.tanggal, '%d %M %Y') as tgl, b.idsakit FROM harwat_harsis a, sakit_harsis b where a.idsakit_harsis = b.idsakit_harsis;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                // mencari nama simulator
                $idsim = $this->model->getAllQR("select simulator from sakit where idsakit = '".$row->idsakit."';")->simulator;
                $namasim = $this->model->getAllQR("select nama_simulator from simulator where idsimulator = '".$idsim."';")->nama_simulator;
                $val[] = $namasim;
                $val[] = $row->tgl;
                $val[] = $row->kegiatan;
                $val[] = $row->pelaksanaan;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idharwat_harsis."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idharwat_harsis."'".','."'".$no."'".')">Hapus</button>'
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
    
    public function ajaxshowsakit() {
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
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="pilih('."'".$row->idsakit_harsis."'".','."'".$row->kerusakan."'".', '."'".$row->tindakan."'".')">Pilih</button>'
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
            $idusers = session()->get("username");
            
            $data = array(
                'idharwat_harsis' => $this->model->autokode("H","idharwat_harsis","harwat_harsis", 2, 7),
                'idsakit_harsis' => $this->request->getPost('idsakit'),
                'tanggal' => $this->request->getPost('tgl'),
                'kegiatan' => $this->request->getPost('kegiatan'),
                'pelaksanaan' => $this->request->getPost('pelaksanaan'),
                'keterangan' => $this->request->getPost('keterangan'),
                'idusers' => $idusers
            );
            $simpan = $this->model->add("harwat_harsis",$data);
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ganti() {
        if(session()->get("logged_in")){
            $kode = $this->request->uri->getSegment(3);
            $data = $this->model->getAllQR("SELECT a.*, b.kerusakan, b.tindakan FROM harwat_harsis a, sakit_harsis b where a.idsakit_harsis = b.idsakit_harsis and a.idharwat_harsis = '".$kode."';");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_in")){
            $idusers = session()->get("username");
            $data = array(
                'idsakit_harsis' => $this->request->getPost('idsakit'),
                'tanggal' => $this->request->getPost('tgl'),
                'kegiatan' => $this->request->getPost('kegiatan'),
                'pelaksanaan' => $this->request->getPost('pelaksanaan'),
                'keterangan' => $this->request->getPost('keterangan'),
                'idusers' => $idusers
            );
            $kond['idharwat_harsis'] = $this->request->getPost('kode');
            $simpan = $this->model->update("harwat_harsis",$data, $kond);
            if($simpan == 1){
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
            $kond['idharwat_harsis'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("harwat_harsis",$kond);
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
        if(session()->get("logged_in")){
            $data['list'] = $this->model->getAllQ("SELECT a.*, date_format(a.tanggal, '%d %M %Y') as tgl, b.idsakit FROM harwat_harsis a, sakit_harsis b where a.idsakit_harsis = b.idsakit_harsis;");
            $data['modul'] = $this->modul;
            $data['model'] = $this->model;
            
            $options = new Options();
            $options->setChroot(FCPATH);
            $dompdf = new Dompdf();
            $dompdf->setOptions($options);
            $dompdf->loadHtml(view('harwat_harsis/pdf', $data));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $filename = 'JURNAL HARWAT HARSIS';
            $dompdf->stream($filename); 
        }else{
            $this->modul->halaman('login');
        }
    }
}
