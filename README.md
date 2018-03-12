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