<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model', 'modelcategorias');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index($enviado=null)
    {
        $this->load->helper('funcoes');
        $dados['categorias'] = $this->categorias;
        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Contato';
        $dados['subtitulo'] = '';
        $dados['enviado'] = $enviado;

        $this->load->view('frontend/template/html-header', $dados);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/contato');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }

    public function enviar_mensagem(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtNome', 'Nome', 'required');
        $this->form_validation->set_rules('txtEmail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('txtMsg', 'Mensagem', 'required');

        if ($this->form_validation->run()) {
            $nome = $this->input->post('txtNome');
            $email = $this->input->post('txtEMail');
            $msg = $this->input->post('txtMsg');
            $ip = $this->input->ip_address();

            $this->load->library('email');
            $this->email->from($email, $nome);
            $this->email->to('teste@email.com'); // email que deseja receber as mensagem do form do contato
            $this->email->subject('Formulário de contato - BLOG CI');
            $this->email->message("
                <p><strong>Nome: </strong> $nome</p>
                <p><strong>Email: </strong> $email</p>
                <p><strong>Mensagem: </strong> $msg</p>
                <p><strong>IP: </strong> $ip </p>
            ");
            if($this->email->send()){
                redirect(base_url("contato/1"));  //ENVIADO!
            }else{
                redirect(base_url("contato/2")); // ERRO
            }

        }else{
            $this->index(); // campos vazios...
        }

    }

}