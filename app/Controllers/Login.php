<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Login extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_in")){
            $this->modul->halaman('home');
        }else if(session()->get("logged_no_admin")){
            $this->modul->halaman('homenoadmin');
        }else{
            $jml = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml > 0){
                $deflogo = base_url().'/images/noimg.png';
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($this->modul->getPathApp().$tersimpan->logo)){
                        $deflogo = base_url().'/uploads/'.$tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            }else{
                $data['logo'] = $deflogo;
            }

            echo view('login', $data);
        }
    }
    
    public function proses() {
        clearstatcache();
        
        $user = strtolower(trim($this->request->getVar('nrp')));
        $pass = trim($this->request->getVar('pass'));
        
        $enkrip_pass = $this->modul->enkrip_pass($pass);
        $jml = $this->model->getAllQR("SELECT count(*) as jml FROM users where nrp = '".$user."';")->jml;
        if($jml > 0){
            $jml1 = $this->model->getAllQR("select count(*) as jml from users where nrp = '".$user."' and pass = '".$enkrip_pass."';")->jml;
            if($jml1 > 0){
                $data = $this->model->getAllQR("select idusers, nrp, nama, idrole from users where nrp = '".$user."';");
                if($data->idrole == "R00001"){
                    session()->set([
                        'username' => $data->idusers,
                        'nrp' => $data->nrp,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'logged_in' => TRUE
                    ]);
                    $status = "ok";
                }else{
                    session()->set([
                        'username' => $data->idusers,
                        'nrp' => $data->nrp,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'logged_no_admin' => TRUE
                    ]);
                    $status = "ok_no_admin";
                }
            }else{
                $status = "Anda tidak berhak mengakses !";
            }
        }else{
            $status = "Maaf, user tidak ditemukan !";
        }
        echo json_encode(array("status" => $status));   
    }
    
    public function logout(){
        session()->destroy();
        clearstatcache();
        
        $this->modul->halaman('login');
    }
    
}
