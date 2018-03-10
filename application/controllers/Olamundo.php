<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Olamundo extends CI_Controller
{
    public function index()
    {
        $dados['mensagem'] = 'ola mundo';
        $this->load->view('olamundo', $dados);
    }

    public function teste()
    {
        $dados['mensagem'] = 'testando';
        $this->load->view('olamundo', $dados);
    }
}