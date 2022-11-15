<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Personil extends BaseController {
    
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
            
            $data['depar'] = $this->model->getAllQ("select * from role where idrole <> 'R00001';");
            
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
            
            $data['korps'] = $this->model->getAll("korps");
            $data['pangkat'] = $this->model->getAll("pangkat");
            $data['hakakses'] = $this->model->getAll("role");
            $data['divisi'] = $this->model->getAll("divisi");
            $data['jabatan'] = $this->model->getAll("jabatan");

            echo view('head', $data);
            echo view('menu');
            echo view('personil/index');
            echo view('foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if(session()->get("logged_in")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.*, b.nama_korps, c.nama_pangkat, d.nama_role from users a, korps b , pangkat c, role d where a.idrole = d.idrole and a.idkorps = b.idkorps and a.idpangkat = c.idpangkat;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nrp;
                $val[] = $row->nama;
                $val[] = $row->nama_korps;
                $val[] = $row->nama_pangkat;
                $val[] = $row->nama_role;
                if(strlen($row->iddivisi) > 0 && $row->iddivisi <> "-"){
                    $val[] = $this->model->getAllQR("select nama_divisi from divisi where iddivisi = '".$row->iddivisi."';")->nama_divisi;
                }else{
                    $val[] = "";
                }
                if(strlen($row->idjabatan) > 0 && $row->idjabatan <> "-"){
                    $val[] = $this->model->getAllQR("select nama_jabatan from jabatan where idjabatan = '".$row->idjabatan."';")->nama_jabatan;
                }else{
                    $val[] = "";
                }
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idusers."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idusers."'".','."'".$row->nrp."'".')">Hapus</button>'
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
            $data = array(
                'idusers' => $this->model->autokode("U","idusers","users", 2, 7),
                'nrp' => $this->request->getPost('nrp'),
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'pass' => $this->modul->enkrip_pass("123"),
                'idrole' => $this->request->getPost('role'),
                'idpangkat' => $this->request->getPost('pangkat'),
                'idkorps' => $this->request->getPost('korps'),
                'foto' => '',
                'iddivisi' => $this->request->getPost('iddivisi'),
                'idjabatan' => $this->request->getPost('idjabatan')
            );
            $simpan = $this->model->add("users",$data);
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
            $kond['idusers'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("users", $kond);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_in")){
            $data = array(
                'nrp' => $this->request->getPost('nrp'),
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'pass' => $this->modul->enkrip_pass("123"),
                'idrole' => $this->request->getPost('role'),
                'idpangkat' => $this->request->getPost('pangkat'),
                'idkorps' => $this->request->getPost('korps'),
                'iddivisi' => $this->request->getPost('iddivisi'),
                'idjabatan' => $this->request->getPost('idjabatan')
            );
            $kond['idusers'] = $this->request->getPost('kode');
            $update = $this->model->update("users",$data, $kond);
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
            $kond['idusers'] = $this->request->uri->getSegment(3);
            $logo = $this->model->getAllQR("SELECT foto FROM users where idusers = '".$kond['idusers']."';")->foto;
            if(strlen($logo) > 0){
                if(file_exists($this->modul->getPathApp().$logo)){
                    unlink($this->modul->getPathApp().$logo); 
                }
            }
        
            $hapus = $this->model->delete("users",$kond);
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
