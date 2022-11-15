<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use Dompdf\Dompdf;

class Suratmasuk extends BaseController {
    
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
            echo view('suratmasuk/index');
            echo view('foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if(session()->get("logged_in")){
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT suratmasuk.*, users.nrp, users.nama, simulator.nama_simulator, date_format(tanggal, '%d %M %Y') as tgl FROM suratmasuk
                LEFT JOIN users ON suratmasuk.idusers = users.idusers
                LEFT JOIN simulator ON suratmasuk.idsimulator = simulator.idsimulator");
            foreach ($list->getResult() as $row) {
                $val = array();
                if($row->nama_simulator == "SEMENTARA"){
                    $val[] = $no;
                    $val[] = '<label style="color:red;">'.$row->nama_simulator.'</label>';
                    $val[] = '<label style="color:red;">'.$row->tgl.'</label>';
                    $val[] = '<label style="color:red;">'.$row->nosurat.'</label>';
                    $val[] = '<label style="color:red;">'.$row->dari.'</label>';
                    $val[] = '<label style="color:red;">'.$row->perihal.'</label>';
                    $val[] = '<label style="color:red;">'.$row->keterangan.'</label>';
                }else{
                    $val[] = $no;
                    $val[] = $row->nama_simulator;
                    $val[] = $row->tgl;
                    $val[] = $row->nosurat;
                    $val[] = $row->dari;
                    $val[] = $row->perihal;
                    $val[] = $row->keterangan;
                }
                
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idsuratmasuk."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idsuratmasuk."'".','."'".$no."'".')">Hapus</button>'
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
                'idsuratmasuk' => $this->model->autokode("S","idsuratmasuk","suratmasuk", 2, 7),
                'idusers' => $idusers,
                'idsimulator' => $this->request->getPost('kode_sim'),
                'tanggal' => $this->request->getPost('tanggal'),
                'nosurat' => $this->request->getPost('nosurat'),
                'dari' => $this->request->getPost('dari'),
                'perihal' => $this->request->getPost('perihal'),
                'keterangan' => $this->request->getPost('keterangan'),
                'mode' => $this->request->getPost('mode')
            );
            $simpan = $this->model->add("suratmasuk",$data);
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
    
    public function ganti(){
        if(session()->get("logged_in")){
            $idsimulator = $this->request->uri->getSegment(3);
            $tersimpan = $this->model->getAllQR("SELECT * FROM suratmasuk where idsuratmasuk = '".$idsimulator."';");
            if(strlen($tersimpan->idsimulator) > 0){
                $sim = $this->model->getAllQR("SELECT * FROM simulator where idsimulator = '".$tersimpan->idsimulator."';");
                $idsimulator = $sim->idsimulator;
                $nama_simulator = $sim->nama_simulator;
            }else{
                $idsimulator = "";
                $nama_simulator = "";
            }
            
            echo json_encode(array(
                "idsuratmasuk" => $tersimpan->idsuratmasuk,
                "idsimulator" => $idsimulator,
                "nama_simulator" => $nama_simulator,
                "mode" => $tersimpan->mode,
                "tanggal" => $tersimpan->tanggal,
                "nosurat" => $tersimpan->nosurat,
                "dari" => $tersimpan->dari,
                "perihal" => $tersimpan->perihal,
                "keterangan" => $tersimpan->keterangan,
            ));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_in")){
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
            $update = $this->model->update("suratmasuk",$data, $kond);
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
            $kond['idsuratmasuk'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("suratmasuk",$kond);
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
    
    public function ajaxsim() {
        if(session()->get("logged_in")){
            $data = array();
            $list = $this->model->getAll("simulator");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->nama_simulator;
                $val[] = $row->letak;
                $val[] = $row->tahun;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="pilih('."'".$row->idsimulator."'".','."'".$row->nama_simulator."'".')">Pilih</button>'
                        . '</div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function cetak(){
        if(session()->get("logged_in")){
            $data['list'] = $this->model->getAllQ("SELECT suratmasuk.*, users.nrp, users.nama, simulator.nama_simulator, date_format(tanggal, '%d %M %Y') as tgl FROM suratmasuk
                LEFT JOIN users ON suratmasuk.idusers = users.idusers
                LEFT JOIN simulator ON suratmasuk.idsimulator = simulator.idsimulator");
            
            $dompdf = new Dompdf();
            $dompdf->loadHtml(view('suratmasuk/pdf', $data));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $filename = 'SuratMasuk';
            $dompdf->stream($filename); 
        }else{
            $this->modul->halaman('login');
        }
    }
}
