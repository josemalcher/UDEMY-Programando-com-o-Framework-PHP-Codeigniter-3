# Criando Aplicações Web com o Framework PHP CodeIgniter 3

https://www.udemy.com/criando-aplicacoes-web-com-o-framework-php-codeigniter-3/learn/v4/content

---

## <a name="indice">Índice</a>

- [Seção: 1 Introdução](#parte1)   
- [Seção: 2 Iniciando os trabalhos com o CodeIgniter 3](#parte2)   
- [Seção: 3 Criando o Front-end do Blog](#parte3)   
- [Seção: 4 Criando o Back-end do Blog](#parte4)   
- [Seção: 5 Publicando nossa aplicação na Web](#parte5)   
- [Seção: 6 Ajustes Pós Curso](#parte6)   
- [Seção: 7 Conteúdo Bônus](#parte7)   

---

## <a name="parte1">Seção: 1 Introdução</a>

- https://www.devmedia.com.br/introducao-ao-framework-php-codeigniter/27346
- https://tableless.com.br/porque-codeigniter-ainda-e-uma-boa-opcao/
- http://www.rafaelwendel.com/2013/01/introducao-ao-codeigniter-framework/
- http://www.universidadecodeigniter.com.br/


[Voltar ao Índice](#indice)

---

## <a name="parte2">Seção: 2 Iniciando os trabalhos com o CodeIgniter 3</a>

#### Seção 2, aula 8. Ativando a reescrita de URL 
- .htaccess
```apacheconfig
<IfModule mod_rewrite.c>
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

#### Seção 2, aula 9. Configurando os arquivos Config, Routes e Autoload
- application/config/config.php
```php
$config['base_url'] = 'http://localhost/workspace-criando-aplicacoes-web-com-o-framework-php-codeigniter-3/';

```
- application/config/autoload.php
```php
$autoload['helper'] = array('url','form','html');
```
####  Seção 2, aula 10 - Criando e acessando Métodos nos Controladores 

- application/controllers/Olamundo.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Olamundo extends CI_Controller
{
    public function index()
    {
        $dados['mensagem'] = 'ola mundo';
        $this->load->view('olamundo', $dados);
        //http://localhost/workspace-criando-aplicacoes-web-com-o-framework-php-codeigniter-3/
    }

    public function teste()
    {
        $dados['mensagem'] = 'testando';
        $this->load->view('olamundo', $dados);
        //http://localhost/workspace-criando-aplicacoes-web-com-o-framework-php-codeigniter-3/olamundo/teste
    }
}
```
- application/views/olamundo.php
```php
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $mensagem?></title>
</head>
<body>
<h1><?php echo $mensagem?></h1>
</body>
</html>
```

#### Seção 2, aula 11 Configurando e testando a conexão com o Banco de Dados

- application/config/autoload.php
```php
$autoload['libraries'] = array('database');
```

- application/config/database.php
```php
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'udemy_ci_blog',
```

- application/controllers/Olamundo.php
```php
    public function testeDb(){
        $dados['mensagem'] = $this->db->get('postagens')->result();
        echo "<pre>";
        print_r($dados);
    }
//http://localhost/workspace-criando-aplicacoes-web-com-o-framework-php-codeigniter-3/olamundo/testedb    
```

#### Seção 2, 12. Realizando a tradução do Framework

https://github.com/CIBr/CodeIgniter-Portuguese-BR

- application/config/config.php
```php
    $config['language']	= 'portuguese-brazilian';
```

#### Seção 2, 13. Criando um Helper para formatar a URL

- application/helpers/funcoes_helper.php
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function limpar($string){
    $table = array(
        '/'=>'', '('=>'', ')'=>'',
    );
    // Traduz os caracteres em $string, baseado no vetor $table
    $string = strtr($string, $table);
    $string= preg_replace('/[,.;:`´^~\'"]/', null, iconv('UTF-8','ASCII//TRANSLIT',$string));
    $string= strtolower($string);
    $string= str_replace(" ", "-", $string);
    $string= str_replace("---", "-", $string);
    return $string;
}
```

- application/config/autoload.php
```php
$autoload['helper'] = array('url','form','html','funcoes');

```

#### Seção 2, 14. Preparando o template master do Front-end do Blog

- application/views/frontend/template varios arquivos para o front-end do blog


[Voltar ao Índice](#indice)

---

## <a name="parte3">Seção: 3 Criando o Front-end do Blog</a>

#### Seção 3, 16. Modelando as view da Home

- application/controllers/Home.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $this->load->view('frontend/template/html-header');
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/home');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }


}
```

#### 17. Instalando o banco de dados e modelando o primeiro Model

- application/models/Categorias_model.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_model extends CI_Model {

    public $id;
    public $titulo;

    public function __construct()
    {
        parent::__construct();
    }

    public function listar_categorias(){
        $this->db->order_by('titulo','ASC');
        return $this->db->get('categoria')->result();
    }

}
```
- application/controllers/Home.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model','modelcategorias');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index()
    {
        $dados['categorias'] = $this->categorias;

        $this->load->view('frontend/template/html-header', $dados);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/home');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }


}
```

#### 18. Exibindo os primeiros resultados do Model na View

- application/views/frontend/template/aside.php
- application/views/frontend/template/header.php

```php
<?php
foreach ($categorias as $categoria) {
?>
    <li>
    <a href="<?php echo base_url('categoria/' . $categoria->id . '/' . limpar($categoria->titulo)) ?>"><?php echo $categoria->titulo ?></a>
    </li>
    <?php
}
?>
```

####  19. Criando a área de destaque de publicações na Home de nosso Blog

- application/models/Publicacoes_model.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Publicacoes_model extends CI_Model {

    public $id;
    public $categoria;
    public $titulo;
    public $subtitulo;
    public $conteuto;
    public $data;
    public $img;
    public $user;

    public function __construct()
    {
        parent::__construct();
    }

    public function destaques_home(){
        $this->db->limit(4);
        $this->db->order_by('data','DESC');
        return $this->db->get('postagens')->result();
    }

}
```

- application/controllers/Home.php

```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model','modelcategorias');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index()
    {
        $dados['categorias'] = $this->categorias;

        $this->load->model('publicacoes_model','modelpublicacoes');
        $dados['postagem'] = $this->modelpublicacoes->destaques_home();

        $this->load->view('frontend/template/html-header', $dados);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/home');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }


}
```

- application/views/frontend/home.php

```php
<?php
            foreach ($postagem as $destaque) {
                ?>
                <h2>
                    <a href="<?php echo base_url('postagem/' . $destaque->id . '/' . limpar($destaque->titulo)) ?>"><?php echo $destaque->titulo; ?></a>
                </h2>
                <p class="lead">
                    por <a href="index.php">Start Bootstrap</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Postado em 25 de Janeiro de 2017 10:00</p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p><?php echo $destaque->subtitulo ?></p>
                <a class="btn btn-primary"
                   href="<?php echo base_url('postagem/' . $destaque->id . '/' . limpar($destaque->titulo)) ?>">Leia
                    mais <span
                            class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php
            }
            ?>
```

#### 20. Criando um Helper para formatação da Data e Hora

- application/helpers/funcoes_helper.php

```php
function postadoem($string)
{

    $dia_sem = date('w', strtotime($string));

    if ($dia_sem == 0) {
        $semana = "Domingo";
    } elseif ($dia_sem == 1) {
        $semana = "Segunda-feira";
    } elseif ($dia_sem == 2) {
        $semana = "Terça-feira";
    } elseif ($dia_sem == 3) {
        $semana = "Quarta-feira";
    } elseif ($dia_sem == 4) {
        $semana = "Quinta-feira";
    } elseif ($dia_sem == 5) {
        $semana = "Sexta-feira";
    } else {
        $semana = "Sábado";
    }

    $dia = date('d', strtotime($string));

    $mes_num = date('m', strtotime($string));
    if ($mes_num == 1) {
        $mes = "Janeiro";
    } elseif ($mes_num == 2) {
        $mes = "Fevereiro";
    } elseif ($mes_num == 3) {
        $mes = "Março";
    } elseif ($mes_num == 4) {
        $mes = "Abril";
    } elseif ($mes_num == 5) {
        $mes = "Maio";
    } elseif ($mes_num == 6) {
        $mes = "Junho";
    } elseif ($mes_num == 7) {
        $mes = "Julho";
    } elseif ($mes_num == 8) {
        $mes = "Agosto";
    } elseif ($mes_num == 9) {
        $mes = "Setembro";
    } elseif ($mes_num == 10) {
        $mes = "Outubro";
    } elseif ($mes_num == 11) {
        $mes = "Novembro";
    } else {
        $mes = "Dezembro";
    }

    $ano = date('Y', strtotime($string));
    $hora = date('H:i', strtotime($string));

    return $semana . ', ' . $dia . ' de ' . $mes . ' de ' . $ano . ' ' . $hora;
}
```

- application/views/frontend/home.php
```php
       <p><span class="glyphicon glyphicon-time"></span> <?php echo postadoem($destaque->data); ?></p>
```

#### 21. Exibindo o nome do autor com ajuda da cláusula JOIN

- application/models/Publicacoes_model.php

```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Publicacoes_model extends CI_Model {

    public $id;
    public $categoria;
    public $titulo;
    public $subtitulo;
    public $conteuto;
    public $data;
    public $img;
    public $user;

    public function __construct()
    {
        parent::__construct();
    }

    public function destaques_home(){
        $this->db->select('usuario.id as idautor, usuario.nome, 
                           postagens.id, postagens.titulo, postagens.subtitulo, postagens.user, postagens.data, postagens.img');
        $this->db->from('postagens');
        $this->db->join('usuario', 'usuario.id = postagens.user');
        $this->db->limit(4);
        $this->db->order_by('postagens.data','DESC');
        return $this->db->get()->result();
    }

}
```

- application/views/frontend/home.php
```php
         <p class="lead">
            por <a href="<?php echo base_url('autor/'. $destaque->idautor .'/'.limpar($destaque->nome)); ?>"><?php echo $destaque->nome ?></a>
         </p>
```

#### 22. Carregando o título e o cabeçalho das páginas de forma dinâmica

- application/controllers/Home.php

```php
       //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Página Inicial';
        $dados['subtitulo'] = 'Postagens Recentes';
```

-application/views/frontend/home.php

```php
            <h1 class="page-header">
                <?php echo $titulo; ?>
                <small><?php echo $subtitulo; ?></small>
            </h1>
```
-application/views/frontend/template/html-header.php

```php
    <title><?php echo $titulo. ' - '. $subtitulo; ?></title>
```

[Voltar ao Índice](#indice)

---

## <a name="parte4">Seção: 4 Criando o Back-end do Blog</a>


[Voltar ao Índice](#indice)

---

## <a name="parte5">Seção: 5 Publicando nossa aplicação na Web</a>


[Voltar ao Índice](#indice)

---

## <a name="parte6">Seção: 6 Ajustes Pós Curso</a>


[Voltar ao Índice](#indice)

---

## <a name="parte7">Seção: 7 Conteúdo Bônus</a>


[Voltar ao Índice](#indice)

---

---