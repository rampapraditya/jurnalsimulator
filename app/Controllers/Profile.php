<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Profile extends BaseController {
    
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
            $data['foto_profile'] = $def_foto;
            $data['nrp_profile'] = $pro_tersimpan->nrp;
            $data['nama_profile'] = $pro_tersimpan->nama;
            $data['korps_profile'] = $pro_tersimpan->idkorps;
            $data['pangkat_profile'] = $pro_tersimpan->idpangkat;

            $data['korps'] = $this->model->getAll("korps");
            $data['pangkat'] = $this->model->getAll("pangkat");
            
            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml_identitas > 0){
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $data['instansi'] = $tersimpan->instansi;
                $data['slogan'] = $tersimpan->slogan;
                $data['tahun'] = $tersimpan->tahun;
                $data['pimpinan'] = $tersimpan->pimpinan;
                $data['alamat'] = $tersimpan->alamat;
                $data['kdpos'] = $tersimpan->kdpos;
                $data['tlp'] = $tersimpan->tlp;
                $data['fax'] = $tersimpan->fax;
                $data['website'] = $tersimpan->website;
                $data['lat'] = $tersimpan->lat;
                $data['lon'] = $tersimpan->lon;
                $data['email'] = $tersimpan->email;
                $deflogo = base_url().'/images/noimg.png';
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($this->modul->getPathApp().$tersimpan->logo)){
                        $deflogo = base_url().'/uploads/'.$tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
                
            }else{
                $data['instansi'] = "";
                $data['slogan'] = "";
                $data['tahun'] = "";
                $data['pimpinan'] = "";
                $data['alamat'] = "";
                $data['tlp'] = "";
                $data['fax'] = "";
                $data['website'] = "";
                $data['lat'] = "";
                $data['lon'] = "";
                $data['email'] = "";
                $data['logo'] = base_url().'/images/noimg.png';
            }

            echo view('head', $data);
            echo view('menu');
            echo view('profile/index');
            echo view('foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if(session()->get("logged_in")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->updatedenganfoto();
                }
            }else{
                $status = $this->updatetanpafoto();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function updatedenganfoto() {
        $idusers = session()->get("username");
        $lawas = $this->model->getAllQR("SELECT foto FROM users where idusers = '".$idusers."';")->foto;
        if(strlen($lawas) > 0){
            if(file_exists($this->modul->getPathApp().$lawas)){
                unlink($this->modul->getPathApp().$lawas); 
            }
        }
        
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        // cek nama file ada apa tidak
        if(file_exists($this->modul->getPathApp().$namaFile)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move($this->modul->getPathApp(), $namaFile);
            if($status_upload){
                $data = array(
                    'nama' => $this->request->getVar('nama'),
                    'idkorps' => $this->request->getVar('korps'),
                    'idpangkat' => $this->request->getVar('pangkat'),
                    'foto' => $namaFile
                );
                $kond['idusers'] = $idusers;
                $update = $this->model->update("users",$data, $kond);
                if($update == 1){
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
    
    private function updatetanpafoto() {
        $idusers = session()->get("username");
        $data = array(
            'nama' => $this->request->getVar('nama'),
            'idkorps' => $this->request->getVar('korps'),
            'idpangkat' => $this->request->getVar('pangkat')
        );
        $kond['idusers'] = $idusers;
        $update = $this->model->update("users",$data, $kond);
        if($update == 1){
            $status = "Data terupdate";
        }else{
            $status = "Data gagal terupdate";
        }
        return $status;
    }
}
