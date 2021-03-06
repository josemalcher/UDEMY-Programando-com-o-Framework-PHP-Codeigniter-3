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

#### 23. Criando a página categorias e a primeira rota personalizada

- application/config/routes.php

```php
$route['categoria/(:num)/(:any)'] ='categorias/index/$1/$2' ;
```

- application/controllers/Categorias.php

```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model','modelcategorias');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index($id, $slug = null)
    {
        $dados['categorias'] = $this->categorias;

        $this->load->model('publicacoes_model','modelpublicacoes');
        $dados['postagem'] = $this->modelpublicacoes->categoria_pub($id);

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Categorias';
        $dados['subtitulo'] = 'Postagens Recentes';

        $this->load->view('frontend/template/html-header', $dados);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/categoria');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }
}
```

- application/views/frontend/categoria.php

```php
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                <?php echo $titulo; ?>
                <small><?php echo $subtitulo; ?></small>
            </h1>

            <?php
            foreach ($postagem as $destaque) {
                ?>
                <h2>
                    <a href="<?php echo base_url('postagem/' . $destaque->id . '/' . limpar($destaque->titulo)); ?>"><?php echo $destaque->titulo; ?></a>
                </h2>
                <p class="lead">
                    por <a href="<?php echo base_url('autor/'. $destaque->idautor .'/'.limpar($destaque->nome)); ?>"><?php echo $destaque->nome ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo postadoem($destaque->data); ?></p>
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


        </div>

```

- application/models/Publicacoes_model.php

```php
 public function categoria_pub($id)
    {
        $this->db->select('usuario.id as idautor, usuario.nome, 
                           postagens.id, postagens.titulo, 
                           postagens.subtitulo, postagens.user, 
                           postagens.data, postagens.img,
                           postagens.categoria');
        $this->db->from('postagens');
        $this->db->join('usuario', 'usuario.id = postagens.user');
        $this->db->where('postagens.categoria = '.$id);
        $this->db->order_by('postagens.data', 'DESC');
        return $this->db->get()->result();
    }
```

#### 24. Modificando o título e cabeçalho da página de acordo com a categoria

- application/models/Categorias_model.php
```php
 public function listar_titulo($id){
        $this->db->from('categoria');
        $this->db->where('id =',$id);
        return $this->db->get()->result();
    }
```

- application/controllers/Categorias.php
```php
         $dados['subtitulodb'] = $this->modelcategorias->listar_titulo($id);
```

- application/views/frontend/categoria.php

```php
<h1 class="page-header">
                <?php echo $titulo; ?>
                <small><?php
                        if($subtitulo != ''){
                            echo $subtitulo;
                        }else{
                            foreach ($subtitulodb as $dbtitulo){
                                echo $dbtitulo->titulo;
                            }
                        }

                    ?></small>
            </h1>
```

- application/views/frontend/template/html-header.php

```php
<title><?php echo $titulo . ' - ' ?>
        <?php
        if ($subtitulo != '') {
            echo $subtitulo;
        } else {
            foreach ($subtitulodb as $dbtitulo) {
                echo $dbtitulo->titulo;
            }
        }

        ?>
    </title>
```

#### 25. Criando e configurando a página de publicações

- application/controllers/Postagens.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Postagens extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model','modelcategorias');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index($id, $slug = null)
    {
        $dados['categorias'] = $this->categorias;

        $this->load->model('publicacoes_model','modelpublicacoes');
        $dados['postagem'] = $this->modelpublicacoes->publicacao($id);

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Publicação';
        $dados['subtitulo'] = '';
        $dados['subtitulodb'] = $this->modelpublicacoes->listar_titulo($id);

        $this->load->view('frontend/template/html-header', $dados);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/publicacao');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }
}
```

- application/models/Publicacoes_model.php

```php
public function publicacao($id)
    {
        $this->db->select('usuario.id as idautor, usuario.nome, 
                           postagens.id, postagens.titulo, 
                           postagens.subtitulo, postagens.user, 
                           postagens.data, postagens.img,
                           postagens.categoria, postagens.conteudo');
        $this->db->from('postagens');
        $this->db->join('usuario', 'usuario.id = postagens.user');
        $this->db->where('postagens.id = '.$id);
        return $this->db->get()->result();
    }

    public function listar_titulo($id){
        $this->db->select('id','titulo');
        $this->db->from('postagens');
        $this->db->where('id ='.$id);
        return $this->db->get()->result();
    }
```
- application/views/frontend/publicacao.php

```php
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            foreach ($postagem as $destaque) {
                ?>
                <h1>
                    <?php echo $destaque->titulo; ?>
                </h1>
                <p class="lead">
                    por <a href="<?php echo base_url('autor/'. $destaque->idautor .'/'.limpar($destaque->nome)); ?>"><?php echo $destaque->nome ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo postadoem($destaque->data); ?></p>
                <hr>
                <p><i><?php echo $destaque->subtitulo ?></i></p>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p><?php echo $destaque->conteudo ?></p>
                <hr>
                <?php
            }
            ?>
        </div>
```

#### 26. Criando a página dos autores

- application/controllers/Sobrenos.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sobrenos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model','modelcategorias');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index($id, $slug = null)
    {
        $dados['categorias'] = $this->categorias;

        $this->load->model('publicacoes_model','modelpublicacoes');
        $dados['postagem'] = $this->modelpublicacoes->categoria_pub($id);

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Categorias';
        $dados['subtitulo'] = '';
        $dados['subtitulodb'] = $this->modelcategorias->listar_titulo($id);

        $this->load->view('frontend/template/html-header', $dados);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/categoria');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }
    public function autores($id, $slug = null)
    {
        $dados['categorias'] = $this->categorias;

        $this->load->model('usuarios_model', 'modelusuarios');
        $dados['autores'] = $this->modelusuarios->listar_autor($id);

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Sobre Nós';
        $dados['subtitulo'] = 'Autor';

        $this->load->view('frontend/template/html-header', $dados);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/autor');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }



}
```

- application/views/frontend/autor.php
```php
<!-- Page Content -->
<div class="container">
    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                <?php echo $titulo; ?>
                <small><?php
                    if ($subtitulo != '') {
                        echo $subtitulo;
                    } else {
                        foreach ($subtitulodb as $dbtitulo) {
                            echo $dbtitulo->titulo;
                        }
                    }
                    ?></small>
            </h1>

            <?php
            foreach ($autores as $autor) {
                ?>
                <div class="col-md-4">*
                    <img class="img-responsive img-circle" src="http://placehold.it/200x200" alt="">
                </div>
                <div class="col-md-8 ">
                    <h2>
                        <?php echo $autor->nome ?>
                    </h2>
                    <hr>
                    <p><?php echo $autor->historico ?></p>
                    <hr>
                </div>
                <?php
            }
            ?>
        </div>


```

- application/models/Usuarios_model.php

```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

    public $id;
    public $nome;
    public $email;
    public $img;
    public $historico;
    public $user;
    public $senha;

    public function __construct()
    {
        parent::__construct();
    }

    public function listar_autor($id){
        $this->db->select('id, nome,historico, img');
        $this->db->from('usuario');
        $this->db->where('id =',$id);
        return $this->db->get()->result();
    }

}
```
- application/config/routes.php
```php
$route['autor/(:num)/(:any)'] ='sobrenos/autores/$1/$2';
```

#### 27. Criando a página Sobre Nós

- application/views/frontend/template/header.php
```php
          <a href="<?=base_url('sobrenos')?>">Sobre Nós</a>
```
- application/controllers/Sobrenos.php
```php
 public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model','modelcategorias');
        $this->load->model('usuarios_model', 'modelusuarios');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index()
    {
        $dados['categorias'] = $this->categorias;
        $dados['autores'] = $this->modelusuarios->listar_autores();

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Sobre Nós';
        $dados['subtitulo'] = 'Conheça nossa Equipe';

        $this->load->view('frontend/template/html-header', $dados);
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/sobrenos');
        $this->load->view('frontend/template/aside');
        $this->load->view('frontend/template/footer');
        $this->load->view('frontend/template/html-footer');
    }
```
- application/models/Usuarios_model.php
```php

    public function listar_autores(){
        $this->db->select('id, nome, img');
        $this->db->from('usuario');
        $this->db->order_by('nome','ASC');
        return $this->db->get()->result();
    }
```
- application/views/frontend/sobrenos.php
```php
<!-- Page Content -->
<div class="container">
    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                <?php echo $titulo; ?>
                <small><?php
                    if ($subtitulo != '') {
                        echo $subtitulo;
                    } else {
                        foreach ($subtitulodb as $dbtitulo) {
                            echo $dbtitulo->titulo;
                        }
                    }
                    ?></small>
            </h1>


            <div class="col-md-12 ">

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            </div>
            <br>
            <h1 class="page-header">
                Nossos autores
            </h1>
            <div class="col-md-12 row">
                <?php
                foreach ($autores as $autor) {
                    ?>
                    <div class="col-md-4 col-xs-6">
                        <img class="img-responsive img-circle" src="http://placehold.it/200x200" alt="">
                        <h4 class="text-center">
                            <a href="<?php echo base_url('autor/'. $autor->id .'/'.limpar($autor->nome)); ?>"><?php echo $autor->nome ?></a>
                        </h4>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
```



[Voltar ao Índice](#indice)

---

## <a name="parte4">Seção: 4 Criando o Back-end do Blog</a>

#### 28. Modelando as views na Home do Backend

- application/controllers/admin/Home.php
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

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Home';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/home');
        $this->load->view('backend/template/html-footer');
    }


}
```

-  application/views/backend/home.php
```php
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $subtitulo ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo $subtitulo ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2>Bem vindo ao sistema</h2>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
```

#### 29. Modelando a view Categoria no Backend

- application/controllers/admin/Categoria.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Categoria';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/categoria');
        $this->load->view('backend/template/html-footer');
    }


}
```

- application/views/backend/categoria.php
```php
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo 'Administrar '.$subtitulo;  ?></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo 'Adicionar nova '.$subtitulo;  ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">

                            </div>

                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo 'Alterar '.$subtitulo.' existente' ; ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">

                            </div>

                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<!--
    <form role="form">
        <div class="form-group">
            <label>Titulo</label>
            <input class="form-control" placeholder="Entre com o texto">
        </div>
        <div class="form-group">
            <label>Foto Destaque</label>
            <input type="file">
        </div>
        <div class="form-group">
            <label>Conteúdo</label>
            <textarea class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label>Selects</label>
            <select class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">Cadastrar</button>
        <button type="reset" class="btn btn-default">Limpar</button>
    </form>-->
```

#### 30. Listando as categorias com ajuda da Biblioteca Table do Framework

- application/controllers/admin/Categoria.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model','modelcategorias');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }

    public function index()
    {
        $this->load->library('table');

        $dados['categorias'] = $this->categorias;

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Categoria';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/categoria');
        $this->load->view('backend/template/html-footer');
    }


}
```

- application/views/backend/categoria.php
```php
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo 'Alterar '.$subtitulo.' existente' ; ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                    $this->table->set_heading("Nome da Categoria", "ALterar", "Excluir");
                                        foreach ($categorias as $categoria){
                                            $nomecat = $categoria->titulo;
                                            $alterar = anchor(base_url('admin/categoria'), '<i class="fa fa-refresh fa-fw"></i> Alterar');
                                            $excluir = anchor(base_url('admin/categoria'),'<i class="fa fa-remove fa-fw"></i> Excluir');
                                            $this->table->add_row($nomecat, $alterar,$excluir);
                                        }
                                    $this->table->set_template(array(
                                            'table_open' => '<table class="table table-striped">'
                                    ));
                                    echo $this->table->generate();
                                ?>
                            </div>

                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->

```

#### 31. Adicionando novas Categorias na Base de Dados

- application/views/backend/categoria.php
```php
<div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo 'Adicionar nova ' . $subtitulo; ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            echo validation_errors('<div class="alert alert-danger">','</div>');
                            echo form_open('admin/categoria/inserir');
                            ?>
                            <div class="form-group">
                                <label id="txt-categoria">Nome da Categoria</label>
                                <input type="text" name="txt-categoria" class="form-control"
                                       placeholder="Digite o nome da categoria">
                            </div>
                            <button type="submit" class="btn btn-default">Cadastrar</button>
                            <?php
                            echo form_close();
                            ?>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
```

- application/controllers/admin/Categoria.php
```php

    public function inserir(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-categoria','Nome da Categoria', 'required|min_length[3]|is_unique[categoria.titulo]');
        if($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $titulo = $this->input->post('txt-categoria');
            if($this->modelcategorias->adicionar($titulo)){
                redirect(base_url('admin/categoria'));
            }else{
                echo "Houve um erro!";
            }
        }
    }

```

- application/models/Categorias_model.php
```php
    public function adicionar($titulo)
    {
        $dados['titulo'] = $titulo;
        return $this->db->insert('categoria', $dados);
    }
```

#### 32. Excluindo dados das Categorias de Forma Segura

- application/views/backend/categoria.php
```php
             $excluir = anchor(base_url('admin/categoria/excluir/'.md5($categoria->id)), '<i class="fa fa-remove fa-fw"></i> Excluir');
```

- application/controllers/admin/Categoria.php
```php
  public function excluir($id)
    {
        if ($this->modelcategorias->excluir($id)) {
            redirect(base_url('admin/categoria'));
        } else {
            echo "Houve um erro!";
        }
    }
```

- application/models/Categorias_model.php
```php
    public function excluir($id)
    {
        $this->db->where('md5(id)',$id);
        return $this->db->delete('categoria');
    }
```

#### 33. Atualizando as Categorias de Forma Segura

- application/views/backend/categoria.php
```php
    $alterar = anchor(base_url('admin/categoria/alterar/'.md5($categoria->id)), '<i class="fa fa-refresh fa-fw"></i> Alterar');
```

- application/views/backend/alterar-categoria.php
```php
<div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo 'Alterar ' . $subtitulo; ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            echo validation_errors('<div class="alert alert-danger">', '</div>');
                            echo form_open('admin/categoria/salvar_alteracoes');
                            foreach ($categorias as $categoria) {
                                ?>
                                <div class="form-group">
                                    <label id="txt-categoria">Nome da Categoria</label>
                                    <input type="text" name="txt-categoria" class="form-control"
                                           placeholder="Digite o nome da categoria" value="<?php echo $categoria->titulo ?>">
                                </div>
                                <input type="hidden" name="txt-id" id="txt-id"  value="<?php echo $categoria->id ?>" >
                                <button type="submit" class="btn btn-default">Atualizar</button>
                                <?php
                            }
                            echo form_close();
                            ?>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
```

- application/controllers/admin/Categoria.php
```php

    public function alterar($id)
    {
        $this->load->library('table');

        $dados['categorias'] = $this->modelcategorias->listar_categoria($id);

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Categoria';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/alterar-categoria');
        $this->load->view('backend/template/html-footer');
    }

    public function salvar_alteracoes()
    {
        $this->load->library('form_validation'); //mesmas regras...
        $this->form_validation->set_rules('txt-categoria', 'Nome da Categoria', 'required|min_length[3]|is_unique[categoria.titulo]');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $titulo = $this->input->post('txt-categoria');
            $id = $this->input->post('txt-id');
            if ($this->modelcategorias->alterar($titulo, $id)) {
                redirect(base_url('admin/categoria'));
            } else {
                echo "Houve um erro!";
            }
        }
    }
```

- application/models/Categorias_model.php
```php
public function listar_categoria($id)
    {
        $this->db->from('categoria');
        $this->db->where('md5(id)', $id);
        return $this->db->get()->result();
    }

    public function alterar($titulo, $id)
    {
        $dados['titulo'] = $titulo;
        $this->db->where('id', $id);
        return $this->db->update('categoria', $dados);
    }
```

#### 34. Criando e salvando sessões no banco de dados

- application/config/autoload.php
```php
    $autoload['libraries'] = array('database','session');
```

- application/config/config.php
```php
$config['sess_driver'] = 'database'; //files | database
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 0;// 3600 = 1h | 0 = Sessão expira ao fechar o navegador
$config['sess_save_path'] = 'ci_session'; //default = NULL
$config['sess_match_ip'] = TRUE; //grava ip de onde vem
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
```

- SQL
```sql
CREATE TABLE IF NOT EXISTS `ci_session` (

  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
  `data` blob NOT NULL,
  PRIMARY KEY (id),
  KEY `ci_sessions_timestamp` (`timestamp`)
);
```

#### 35. Criando a view de login no painel administrativo

- application/views/backend/login.php
```php
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Entrar no sistema</h3>
                </div>
                <div class="panel-body">
                    <?php
                        echo validation_errors('<div class="alert alert-danger">','</div>');
                        echo form_open('admin/usuarios/login');
                    ?>
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Usuário" name="txt-user" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Senha" name="txt-senha" type="password" value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button class="btn btn-lg btn-success btn-block">Entrar</button>
                        </fieldset>
                    <?php
                        echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
```

- application/controllers/admin/Usuarios.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Home';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/home');
        $this->load->view('backend/template/html-footer');
    }

    public function pag_login()
    {

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Entrar no Sistema';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/login');
        $this->load->view('backend/template/html-footer');
    }


}
```

- application/config/routes.php
```php
$route['admin/login'] = 'admin/usuarios/pag_login';
```

#### 36. Configurando o login e criando uma sessão do usuário

- application/controllers/admin/Usuarios.php
```php

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

            $this->db->where('user',$usuario);
            $this->db->where('senha',$senha);

            $userlogado = $this->db->get('usuario')->result();
            if(count($userlogado) == 1){
                $dadosSessao['userlogado'] = $userlogado[0];
                $dadosSessao['logado'] = TRUE;
                $this->session->set_userdata($dadosSessao);
                redirect(base_url('admin'));
            print_r($userlogado);
            return;
            }else{
                $dadosSessao['userlogado'] = NULL;
                $dadosSessao['logado'] = FALSE;
                $this->session->set_userdata($dadosSessao);
                redirect(base_url('admin/login'));
            }
        }

    }

```

- application/views/backend/home.php
```php
    <h2>Bem vindo ao sistema, <?php echo $this->session->userdata('userlogado')->nome; ?>!</h2>
```

#### 37. Protegendo o acesso as páginas de administração do blog

- application/controllers/admin/Home.php

```php
public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }

    }
```

- application/controllers/admin/Categoria.php

```php
public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        $this->load->model('categorias_model', 'modelcategorias');
        $this->categorias = $this->modelcategorias->listar_categorias();
    }
```

#### 38. Criando um mecanismo de logout do nosso painel administrativo

++ CORREÇÃO: application/controllers/admin/Usuarios.php
```php
  public function index()
    {
        //sem a verificação, estava dando acesso a "admin/usuarios"
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Home';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/home');
        $this->load->view('backend/template/html-footer');
    }
```

- application/controllers/admin/Usuarios.php
```php

    public function logout()
    {
        $dadosSessao['userlogado'] = NULL;
        $dadosSessao['logado'] = FALSE;
        $this->session->set_userdata($dadosSessao);
        redirect(base_url('admin/login'));
    }
```
- application/views/backend/template/template.php
```php
                    <li>
                        <a href="<?php echo base_url('admin/usuarios/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Sair do Sistema</a>
                    </li>
```

#### 39. Modelando a view Usuários no Backend

- application/views/backend/usuarios.php
```php
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo 'Administrar ' . $subtitulo; ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo 'Adicionar novo ' . $subtitulo; ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            echo validation_errors('<div class="alert alert-danger">', '</div>');
                            echo form_open('admin/usuarios/inserir');
                            ?>
                            <div class="form-group">
                                <label id="txt-usuario">Nome do Usuário</label>
                                <input type="text" name="txt-usuario" class="form-control" placeholder="Digite o nome do usuário">
                            </div>
                            <div class="form-group">
                                <label id="txt-email">Email</label>
                                <input type="text" name="txt-email" class="form-control" placeholder="Digite o Email">
                            </div>
                            <div class="form-group">
                                <label id="txt-usuario">Histórico</label>
                                <textarea name="txt-historico" class="form-control" placeholder="Digite o histórico"></textarea>
                            </div>
                            <div class="form-group">
                                <label id="txt-usuario">User</label>
                                <input type="text" name="txt-user" class="form-control" placeholder="Digite o user do usuário">
                            </div>
                            <div class="form-group">
                                <label id="txt-usuario">Senha</label>
                                <input type="password" name="txt-senha" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label id="txt-usuario">Confirme a Senha</label>
                                <input type="password" name="txt-senha" class="form-control" >
                            </div>
                            <button type="submit" class="btn btn-default">Cadastrar</button>
                            <?php
                            echo form_close();
                            ?>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo 'Alterar ' . $subtitulo . ' existente'; ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            $this->table->set_heading("Foto", "Nome do usuário", "ALterar", "Excluir");
                            foreach ($usuarios as $usuario) {
                                $nomeuser = $usuario->nome;
                                $fotouser = "Foto";
                                $alterar = anchor(base_url('admin/usuario/alterar/' . md5($usuario->id)), '<i class="fa fa-refresh fa-fw"></i> Alterar');
                                $excluir = anchor(base_url('admin/usuario/excluir/' . md5($usuario->id)), '<i class="fa fa-remove fa-fw"></i> Excluir');
                                $this->table->add_row($fotouser, $nomeuser, $alterar, $excluir);
                            }
                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-striped">'
                            ));
                            echo $this->table->generate();
                            ?>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<!--
    <form role="form">
        <div class="form-group">
            <label>Titulo</label>
            <input class="form-control" placeholder="Entre com o texto">
        </div>
        <div class="form-group">
            <label>Foto Destaque</label>
            <input type="file">
        </div>
        <div class="form-group">
            <label>Conteúdo</label>
            <textarea class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label>Selects</label>
            <select class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">Cadastrar</button>
        <button type="reset" class="btn btn-default">Limpar</button>
    </form>-->


```

- application/controllers/admin/Usuarios.php
```php
 public function index()
    {
        /* Proteção */
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        $this->load->library('table');

        $this->load->model('usuarios_model','modelusuarios');
        $dados['usuarios'] = $this->modelusuarios->listar_autores();

        //Dados a serem enviados para o Cabeçalho
        $dados['titulo'] = 'Painel de Controle';
        $dados['subtitulo'] = 'Usuários';

        $this->load->view('backend/template/html-header', $dados);
        $this->load->view('backend/template/template');
        $this->load->view('backend/usuarios');
        $this->load->view('backend/template/html-footer');
    }
```

#### 40. Inserindo, excluindo e criptografando o acesso do usuário

- application/controllers/admin/Usuarios.php
```php
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
```

- application/models/Usuarios_model.php
```php
 /************************************* ADMIN USUÁRIO *************************************/

    public function adicionar($nome, $email, $historico, $user, $senha)
    {
       $dados['nome'] = $nome;
       $dados['email'] = $email;
       $dados['historico'] = $historico;
       $dados['user'] = $historico;
       $dados['senha'] = md5($senha);
       return $this->db->insert('usuario',$dados);
    }
    public function excluir($id){
        $this->db->where('md5(id)', $id);
        return $this->db->delete('usuario');
    }
```

#### 41. Atualizando os usuários de Forma Segura

*** Há um bug que será corrigido nas proximas aulas!

- application/models/Usuarios_model.php

```php

    /* função chamada em Alterar Usuários*/
    public function listar_usuarios($id)
    {
        $this->db->select('id,nome,historico,email,user');
        $this->db->from('usuario');
        $this->db->where('md5(id)',$id);
        return $this->db->get()->result();
    }

    public function alterar($nome, $email, $historico, $user, $senha,$id){
        $dados['nome'] = $nome;
        $dados['email'] = $email;
        $dados['historico'] = $historico;
        $dados['user'] = $user;
        $dados['senha'] = md5($senha);
        $dados['id'] = $id;
        $this->db->where('id',$id);
        return $this->db->update('usuario', $dados);
    }

```

- application/controllers/admin/Usuarios.php

```php
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

    public function salvar_alteracoes()
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
        $this->form_validation->set_rules('txt-senha', 'Senha', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-confir-senha', 'Senha de Confirmação', 'required|matches[txt-senha]');
        if ($this->form_validation->run() == FALSE) {
            //$this->output->enable_profiler(true); //  <<<<<------  DEBUG  ****----
            $this->alterar();
        } else {
            $nome        = $this->input->post('txt-usuario');
            $email       = $this->input->post('txt-email');
            $historico   = $this->input->post('txt-historico');
            $user        = $this->input->post('txt-user');
            $senha       = $this->input->post('txt-senha');
            $id          = $this->input->post('txt-id');
            if ($this->modelusuarios->alterar($nome, $email, $historico, $user, $senha, $id)) {
                redirect(base_url('admin/usuarios'));
            } else {
                "HOUVE UM ERRO AO ALTERAR CADASTRO DE USUÁRIO!";
            }
        }

    }


```

#### 42. Criando um formulário multipart/form-data para upload de imagens

- application/views/backend/alterar-usuario.php

```php
       <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                        <?php
                        $divopen = '<div class="form-group">';
                        $divclose = '</div>';
                        echo form_open_multipart('admin/usuarios/nova_foto');
                        echo form_hidden('id', md5($usuario->id));
                        echo $divopen;
                        $imagem = array('name'=>'userfile', 'id'=>'userfile', 'class'=>'form-control');
                        echo form_upload($imagem);
                        echo $divclose;
                        echo $divopen;
                        $botao = array('name'=>'btn_adicionar', 'id'=>'btn_adicionar','class'=>'btn btn-default', 'value'=>'Adicionar nova imagem');
                        echo form_submit($botao);
                        echo $divclose;
                        echo form_close();
                        }
                        ?>
                        </div>

```

#### 43. Realizando o upload e redimensionamento de imagens no blog

- application/controllers/admin/Usuarios.php

```php

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
                redirect(base_url('admin/usuarios/alterar/' . $id));
            } else {
                echo $this->image_lib->display_errors();
            }
        }

    }
```

#### 44. Informando ao Banco de Dados que o usuário possui uma foto

-
```php
 public function alterar_img($id)
    {
        $dados['img']= 1;
        $this->db->where('md5(id)', $id);
        return $this->db->update('usuario', $dados);
    }
```


#### 45. Exibindo as imagens dos usuários no front e backend

- application/views/backend/alterar-usuario.php

```php
                        <div class="col-lg-3 col-lg-offset-3">
                            <?php
                            if ($usuario->img == 1) {
                                echo img("assets/frontend/img/usuarios/" . md5($usuario->id) . ".jpg");
                            } else {
                                echo img("assets/frontend/img/semfoto.png");
                            }
                            ?>
                        </div>
```

- application/views/frontend/sobrenos.php && application/views/frontend/autor.php

```php
                        <div class="col-md-4 col-xs-6">
                        <?php
                        if ($autor->img == 1) {
                            $mostrarImg = "assets/frontend/img/usuarios/" . md5($autor->id) . ".jpg";
                        } else {
                            $mostrarImg = "assets/frontend/img/semFoto.png";
                        }
                        ?>
                        <img class="img-responsive img-circle" src="<?php echo base_url($mostrarImg); ?>" alt="">
```



#### 46. Teste seus conhecimentos antes de ir para as próximas aulas

#### 47. Modelando a view Publicação no Backend

- application/controllers/admin/Publicacao.php

```php
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
```

- application/models/Publicacoes_model.php

```php
    public function listar_publicacao(){
        $this->db->order_by('data', 'DESC');
        return $this->db->get('postagens')->result();
    }
```

Criação da View: application/views/backend/publicacao.php


#### 48. Inserindo e excluindo publicações no Blog

- application/controllers/admin/Publicacao.php

```php

    public function inserir()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-titulo', 'Título', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-subtitulo', 'SubTitulo', 'required|min_length[3]');
        $this->form_validation->set_rules('txt-conteudo', 'Conteúdo', 'required|min_length[5]');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        }else{
            $titulo = $this->input->post('txt-titulo');
            $subtitulo = $this->input->post('txt-subtitulo');
            $conteudo = $this->input->post('txt-conteudo');
            $datapub = $this->input->post('txt-data');
            $categoria = $this->input->post('select-categoria');
            $userpub = $this->input->post('txt-usuario');
            if ($this->modelpublicacao->adicionar($titulo, $subtitulo, $conteudo,$datapub,$categoria,$userpub)) {
                redirect(base_url('admin/publicacao'));
            }else{
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
```

- application/models/Publicacoes_model.php

```php

    public function adicionar($titulo, $subtitulo, $conteudo,$datapub,$categoria,$userpub)
    {
        $dados['titulo'] = $titulo;
        $dados['subtitulo'] = $subtitulo;
        $dados['conteudo'] = $conteudo;
        $dados['data'] = $datapub;
        $dados['user'] = $userpub;
        $dados['categoria'] = $categoria;
        return $this->db->insert('postagens', $dados);
    }

    public function excluir($id)
    {
        $this->db->where('md5(id)', $id);
        return $this->db->delete('postagens');
    }
```



[Voltar ao Índice](#indice)

---

## <a name="parte5">Seção: 5 Publicando nossa aplicação na Web</a>


[Voltar ao Índice](#indice)

---

## <a name="parte6">Seção: 6 Ajustes Pós Curso</a>


[Voltar ao Índice](#indice)

---

## <a name="parte7">Seção: 7 Conteúdo Bônus</a>

#### 61. Criando um Paginador no Backend



[Voltar ao Índice](#indice)

---

---