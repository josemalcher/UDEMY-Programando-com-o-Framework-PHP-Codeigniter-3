<!-- Page Content -->
<div class="container">
    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header"><?php echo $titulo; ?></h1>


            <div class="col-md-12">
                <?php
                $atributosForm = array('name' => 'formulario_contato', 'id' => 'formulario_contato');
                echo form_open(base_url('contato/enviar_mensagem'), $atributosForm);

                $atribNome = array('name' => 'txtNome', 'id' => 'txtNome', 'class' => 'form-control', 'placeholder' => 'Digite seu Nome');
                echo ("<div class='form-group'>") .
                    form_label("Nome", 'txtNome') .
                    form_input($atribNome) .
                    ("</div>");

                $atribEmail = array('name' => 'txtEmail', 'id' => 'txtEmail', 'class' => 'form-control', 'placeholder' => 'Digite seu Email');
                echo ("<div class='form-group'>") .
                    form_label("Email", 'txtEmail') .
                    form_input($atribEmail) .
                    (" </div>");

                $atribMsg = array('name' => 'txtMsg', 'id' => 'txtMsg', 'class' => 'form-control', 'placeholder' => 'Digite sua mensagem');
                echo ("<div class='form-group'>") .
                    form_label("Mensagem", 'txtMsg') .
                    form_textarea($atribMsg) .
                    (" </div>");


                echo form_submit('btn_enviar', 'Enviar Mensagem');

                echo form_close();

                ?>
            </div>


        </div>

