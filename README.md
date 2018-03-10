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

#### 8. Ativando a reescrita de URL 
- .htaccess
```apacheconfig
<IfModule mod_rewrite.c>
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

#### 9. Configurando os arquivos Config, Routes e Autoload
- application/config/config.php
```php
$config['base_url'] = 'http://localhost/workspace-criando-aplicacoes-web-com-o-framework-php-codeigniter-3/';

```
- application/config/autoload.php
```php
$autoload['helper'] = array('url','form','html');
```




[Voltar ao Índice](#indice)

---

## <a name="parte3">Seção: 3 Criando o Front-end do Blog</a>


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