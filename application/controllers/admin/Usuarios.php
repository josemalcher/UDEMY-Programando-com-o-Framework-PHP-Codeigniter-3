<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        /* Proteção */
        if (!$this->session->userdata('logado')) {
            redirect(base_url('admin/login'));
        }
        $this->load->library('table');

        $this->load->model('usuarios_model', 'modelusuarios');
        $dados['usuarios'] = $this->modelusuarios->listar_autores();

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Usuários';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/usuarios');
        $this->load->view('backend/template/html-footer');
    }

    /************************************* ADMIN USUÁRIO *************************************/
    public function inserir()
    {
        $this->load->model('usuarios_model', 'modelusuarios');
        /* Proteção */
        if (!$this->session->userdata('logado')) {
            redirect(base_url('admin/login'));
        }
        /*regras de validação*/
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-usuario', 'Nome do Usuário', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('txt-historico', 'Histórico', 'required|min_length[10]');
        $this->form_validation->set_rules('txt-user', 'Nome de Usuário', 'required|min_length[3]|is_unique[usuario.user]');
        $this->form_validation->set_rules('txt-senha', 'Senha', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-confir-senha', 'Senha de Confirmação', 'required|matches[txt-senha]');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $nome = $this->input->post('txt-usuario');
            $email = $this->input->post('txt-email');
            $historico = $this->input->post('txt-historico');
            $user = $this->input->post('txt-user');
            $senha = $this->input->post('txt-senha');
            if ($this->modelusuarios->adicionar($nome, $email, $historico, $user, $senha)) {
                redirect(base_url('admin/usuarios'));
            } else {
                "HOUVE UM ERRO AO INSERIR USUÁRIO!";
            }
        }
    }

    public function excluir($id)
    {
        $this->load->model('usuarios_model', 'modelusuarios');
        /* Proteção */
        if (!$this->session->userdata('logado')) {
            redirect(base_url('admin/login'));
        }
        if ($this->modelusuarios->excluir($id)) {
            redirect(base_url('admin/usuarios'));
        } else {
            "HOUVE UM ERRO AO EXCLUIR USUÁRIO!";
        }
    }

    public function alterar($id)
    {
        /* Proteção */
        if (!$this->session->userdata('logado')) {
            redirect(base_url('admin/login'));
        }

        $this->load->model('usuarios_model', 'modelusuarios');
        $dados['usuarios'] = $this->modelusuarios->listar_usuarios($id);

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Alterar Usuários';

        //Dados para o cabeçalho
        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/alterar-usuario');
        $this->load->view('backend/template/html-footer');
    }

    public function salvar_alteracoes($idCrip,$userCom)
    {
        /* Proteção */
        if (!$this->session->userdata('logado')) {
            redirect(base_url('admin/login'));
        }

        $this->load->model('usuarios_model', 'modelusuarios');
        /*regras de validação*/
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-usuario', 'Nome do Usuário', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('txt-historico', 'Histórico', 'required|min_length[10]');
        //$this->form_validation->set_rules('txt-user', 'Nome de Usuário', 'required|min_length[3]|is_unique[usuario.user]');
        $this->form_validation->set_rules('txt-user', 'Nome de Usuário', 'required|min_length[3]'); //Verificar Correção
        /*
         *Caso deseje deixar a opção de salvar informações do usuário sem ter que digitar a senha novamente
         * você pode mudar esta situação com uma condicional que deverá ser adicionada no Controlador e no
         * Model, desta forma:
         */
        $senha= $this->input->post('txt-senha');
        if($senha != ""){
            $this->form_validation->set_rules('txt-senha','Senha', 'required|min_length[3]');
            $this->form_validation->set_rules('txt-confir-senha','Confirmar Senha', 'required|matches[txt-senha]');
        }
        // recuperamos o que esta no campo usuário
        $user= $this->input->post('txt-user');

        // verificamos se ele é diferente do que veio inicialmente do banco e que foi passado
        // como parâmetro na URL.
        // Caso seja diferente ele irá verificar se é único e caso seja igual ele não fara nada
        if($userCom != $user){
            $this->form_validation->set_rules('txt-user','User', 'required|min_length[3]|is_unique[usuario.user]');
        }
        if ($this->form_validation->run() == FALSE) {
            //$this->output->enable_profiler(true); //  <<<<<------  DEBUG  ****----
            $this->alterar($idCrip);
        } else {
            $nome = $this->input->post('txt-usuario');
            $email = $this->input->post('txt-email');
            $historico = $this->input->post('txt-historico');
            $user = $this->input->post('txt-user');
            $senha = $this->input->post('txt-senha');
            $id = $this->input->post('txt-id');
            if ($this->modelusuarios->alterar($nome, $email, $historico, $user, $senha, $id)) {
                redirect(base_url('admin/usuarios'));
            } else {
                "HOUVE UM ERRO AO ALTERAR CADASTRO DE USUÁRIO!";
            }
        }

    }

    public function nova_foto()
    {
        /* Proteção */
        if (!$this->session->userdata('logado')) {
            redirect(base_url('admin/login'));
        }
        $this->load->model('usuarios_model', 'modelusuarios');

        $id = $this->input->post('id');
        $config['upload_path'] = './assets/frontend/img/usuarios';
        $config['allowed_types'] = 'jpg';
        $config['file_name'] = $id . ".jpg";
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            echo $this->upload->display_errors();
        } else {
            $config2['source_image'] = './assets/frontend/img/usuarios/' . $id . '.jpg';
            $config2['create_thumb'] = FALSE;
            $config2['width'] = 200;
            $config2['height'] = 200;
            $this->load->library('image_lib', $config2);
            if ($this->image_lib->resize()) {
                if ($this->modelusuarios->alterar_img($id)) {
                    redirect(base_url('admin/usuarios/alterar/' . $id));
                }else{
                    echo "HOUVE UM ERRO NO SISTEMA - NOVA_FOTO";
                }

            } else {
                echo $this->image_lib->display_errors();
            }
        }

    }


    /************************************* LOGIN *************************************/
    public function pag_login()
    {

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Entrar no Sistema';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/login');
        $this->load->view('backend/template/html-footer');

    }

    public function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-user', 'Usuário', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-senha', 'Senha', 'required|min_length[3]');

        if ($this->form_validation->run() == FALSE) {
            $this->pag_login();
        } else {
            $usuario = $this->input->post('txt-user');
            $senha = $this->input->post('txt-senha');

            $this->db->where('user', $usuario);
            $this->db->where('senha', md5($senha));

            $userlogado = $this->db->get('usuario')->result();
            if (count($userlogado) == 1) {
                $dadosSessao['userlogado'] = $userlogado[0];
                $dadosSessao['logado'] = TRUE;
                $this->session->set_userdata($dadosSessao);
                redirect(base_url('admin'));
                print_r($userlogado);
                return;
            } else {
                $dadosSessao['userlogado'] = NULL;
                $dadosSessao['logado'] = FALSE;
                $this->session->set_userdata($dadosSessao);
                redirect(base_url('admin/login'));
            }
        }
    }

    public function logout()
    {
        $dadosSessao['userlogado'] = NULL;
        $dadosSessao['logado'] = FALSE;
        $this->session->set_userdata($dadosSessao);
        redirect(base_url('admin/login'));
    }
}