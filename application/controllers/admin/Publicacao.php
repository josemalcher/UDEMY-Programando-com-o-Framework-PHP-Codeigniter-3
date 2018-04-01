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
        $this->load->helper('funcoes');
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

    public function inserir()
    {
        $this->load->helper('funcoes');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-titulo', 'Título', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-subtitulo', 'SubTitulo', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-conteudo', 'Conteúdo', 'required|min_length[5]');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $titulo = $this->input->post('txt-titulo');
            $subtitulo = $this->input->post('txt-subtitulo');
            $conteudo = $this->input->post('txt-conteudo');
            $datapub = $this->input->post('txt-data');
            $categoria = $this->input->post('select-categoria');
            $userpub = $this->input->post('txt-usuario');
            if ($this->modelpublicacao->adicionar($titulo, $subtitulo, $conteudo, $datapub, $categoria, $userpub)) {
                redirect(base_url('admin/publicacao'));
            } else {
                echo "HOUVE UM ERRO EM INSERIR POSTAGEM!";
            }
        }
    }

    public function excluir()
    {
        if ($this->modelpublicacao->excluir()) {
            redirect(base_url('admin/puclicacao'));
        } else {
            echo "HOUVE UM ERRO AO EXCLUIR A PUBLICAÇÃO!";
        }
    }

    public function alterar($id)
    {
        $this->load->library('table');
        $dados['categorias'] = $this->modelcategorias->listar_categorias();
        $dados['publicacoes'] = $this->modelpublicacao->listar_pulicacoes($id);
        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Publicações';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/alterar-publicacao');
        $this->load->view('backend/template/html-footer');
        //$this->output->enable_profiler(true); // <<<<----- DEBUG
    }

    public function salvar_alteracoes($idCrip)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-titulo', 'Título', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-subtitulo', 'SubTitulo', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-conteudo', 'Conteúdo', 'required|min_length[5]');
        if($this->form_validation->run() == FALSE){
            $this->alterar($idCrip);
        }else{
            $titulo = $this->input->post('txt-titulo');
            $subtitulo = $this->input->post('txt-subtitulo');
            $conteudo = $this->input->post('txt-conteudo');
            $datapub = $this->input->post('txt-data');
            $categoria = $this->input->post('select-categoria');
            $id = $this->input->post('txt-id');
            //$this->output->enable_profiler(true); // <<<<----- DEBUG
            //return;
            if ($this->modelpublicacao->alterar($titulo, $subtitulo,$conteudo,$datapub,$categoria,$id)) {
                redirect(base_url('admin/publicacao'));
            }else{
                echo "HOUVE UM ERRO EM SALVAR_ALTERAÇÕES";
            }
        }
    }

    public function nova_foto()
    {
        /* Proteção */
        if (!$this->session->userdata('logado')) {
            redirect(base_url('admin/login'));
        }

        $id = $this->input->post('id');
        $config['upload_path'] = './assets/frontend/img/publicacao';
        $config['allowed_types'] = 'jpg';
        $config['file_name'] = $id . ".jpg";
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            echo $this->upload->display_errors();
        } else {
            $config2['source_image'] = './assets/frontend/img/publicacao/' . $id . '.jpg';
            $config2['create_thumb'] = FALSE;
            $config2['width'] = 900;
            $config2['height'] = 300;
            $this->load->library('image_lib', $config2);
            if ($this->image_lib->resize()) {
                if ($this->modelpublicacao->alterar_img($id)) {
                    redirect(base_url('admin/publicacao/alterar/' . $id));
                }else{
                    echo "HOUVE UM ERRO NO SISTEMA - Publicacao -  NOVA_FOTO";
                }

            } else {
                echo $this->image_lib->display_errors();
            }
        }

    }


}