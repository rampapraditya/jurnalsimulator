<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Identitas extends BaseController {
    
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
            $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("username")."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_profile'] = $def_foto;
            
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
            echo view('identitas/index');
            echo view('foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if(session()->get("logged_in")){
            $mode = "simpan";
            $jml = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml > 0){
                $mode = "update";
            }

            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    if($mode == "simpan"){
                        $status = $this->simpandenganfoto();
                    }else if($mode == "update"){
                        $status = $this->updatedenganfoto();
                    }
                }
            }else{
                if($mode == "simpan"){
                    $status = $this->simpantanpafoto();
                }else if($mode == "update"){
                    $status = $this->updatetanpafoto();
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpandenganfoto() {
        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists($this->modul->getPathApp().$$namaFile)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move($this->modul->getPathApp(), $namaFile);
            if($status_upload){
                $data = array(
                    'kode' => $this->model->autokode('I','kode', 'identitas', 2, 7),
                    'instansi' => $this->input->getVar('nama'),
                    'slogan' => $this->input->getVar('slogan'),
                    'tahun' => $this->input->getVar('tahun'),
                    'pimpinan' => $this->input->getVar('pimpinan'),
                    'alamat' => $this->input->getVar('alamat'),
                    'kdpos' => $this->input->getVar('kdpos'),
                    'tlp' => $this->input->getVar('tlp'),
                    'fax' => $this->input->getVar('fax'),
                    'email' => $this->input->getVar('email'),
                    'website' => $this->input->getVar('web'),
                    'logo' => $namaFile,
                    'lat' => $this->input->getVar('lat'),
                    'lon' => $this->input->getVar('lon')
                );
                $simpan = $this->model->add("identitas",$data);
                if($simpan == 1){
                    $status = "Identitas tersimpan";
                }else{
                    $status = "Identitas gagal tersimpan";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
                
        return $status;
    }
    
    private function updatedenganfoto() {
        $logo = $this->model->getAllQR("SELECT logo FROM identitas;")->logo;
        if(strlen($logo) > 0){
            if(file_exists($this->modul->getPathApp().$logo)){
                unlink($this->modul->getPathApp().$logo); 
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
                    'instansi' => $this->request->getVar('nama'),
                    'slogan' => $this->request->getVar('slogan'),
                    'tahun' => $this->request->getVar('tahun'),
                    'pimpinan' => $this->request->getVar('pimpinan'),
                    'alamat' => $this->request->getVar('alamat'),
                    'kdpos' => $this->request->getVar('kdpos'),
                    'tlp' => $this->request->getVar('tlp'),
                    'fax' => $this->request->getVar('fax'),
                    'email' => $this->request->getVar('email'),
                    'website' => $this->request->getVar('web'),
                    'lat' => $this->request->getVar('lat'),
                    'lon' => $this->request->getVar('lon'),
                    'logo' => $namaFile
                );
                $update = $this->model->updateNK("identitas",$data);
                if($update == 1){
                    $status = "Identitas terupdate";
                }else{
                    $status = "Identitas gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        
        return $status;
    }
    
    private function simpantanpafoto() {
        $data = array(
            'kode' => $this->model->autokode('I','kode', 'identitas', 2, 7),
            'instansi' => $this->input->getVar('nama'),
            'slogan' => $this->input->getVar('slogan'),
            'tahun' => $this->input->getVar('tahun'),
            'pimpinan' => $this->input->getVar('pimpinan'),
            'alamat' => $this->input->getVar('alamat'),
            'kdpos' => $this->input->getVar('kdpos'),
            'tlp' => $this->input->getVar('tlp'),
            'fax' => $this->input->getVar('fax'),
            'email' => $this->input->getVar('email'),
            'website' => $this->input->getVar('web'),
            'logo' => '',
            'lat' => $this->input->getVar('lat'),
            'lon' => $this->input->getVar('lon')
        );
        $simpan = $this->model->add("identitas",$data);
        if($simpan == 1){
            $status = "Identitas tersimpan";
        }else{
            $status = "Identitas gagal tersimpan";
        }
        return $status;
    }
    
    private function updatetanpafoto() {
        $data = array(
            'instansi' => $this->request->getVar('nama'),
            'slogan' => $this->request->getVar('slogan'),
            'tahun' => $this->request->getVar('tahun'),
            'pimpinan' => $this->request->getVar('pimpinan'),
            'alamat' => $this->request->getVar('alamat'),
            'kdpos' => $this->request->getVar('kdpos'),
            'tlp' => $this->request->getVar('tlp'),
            'fax' => $this->request->getVar('fax'),
            'email' => $this->request->getVar('email'),
            'website' => $this->request->getVar('web'),
            'lat' => $this->request->getVar('lat'),
            'lon' => $this->request->getVar('lon')
        );
        $update = $this->model->updateNK("identitas",$data);
        if($update == 1){
            $status = "Identitas terupdate";
        }else{
            $status = "Identitas gagal terupdate";
        }
        return $status;
    }
}
