<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model', 'modelcategorias');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index()
    {
        $this->load->helper('funcoes');
        $dados['categorias'] = $this->categorias;
        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Contato';
        $dados['subtitulo'] = '';

        $this->load->view('frontend/template/html-header', $dados);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/contato');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }

}