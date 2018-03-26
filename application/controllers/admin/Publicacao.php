<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Publicacao extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logado')) {
            redirect(base_url('admin/login'));
        }
        $this->load->model('categorias_model', 'modelcategorias');
        $this->load->model('publicacoes_model', 'modelpublicacao');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index()
    {
        $this->load->library('table');

        $dados['categorias'] = $this->categorias;
        $dados['publicacoes'] = $this->modelpublicacao->listar_publicacao();

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Publicação';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/publicacao');
        $this->load->view('backend/template/html-footer');
    }
}