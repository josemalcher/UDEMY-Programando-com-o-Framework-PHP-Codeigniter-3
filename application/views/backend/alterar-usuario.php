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
                            echo form_open('admin/usuarios/salvar_alteracoes');

                            foreach ($usuarios as $usuario) {

                                ?>
                                <div class="form-group">
                                    <label id="txt-usuario">Nome do Usuário</label>
                                    <input type="text" name="txt-usuario" class="form-control"
                                           placeholder="Digite o nome do usuário"
                                           value="<?php echo $usuario->nome; ?>">
                                </div>
                                <div class="form-group">
                                    <label id="txt-email">Email</label>
                                    <input type="text" name="txt-email" class="form-control"
                                           placeholder="Digite o Email"
                                           value="<?php echo $usuario->email; ?>">
                                </div>
                                <div class="form-group">
                                    <label id="txt-historico">Histórico</label>
                                    <textarea name="txt-historico" id="txt-historico"
                                              class="form-control"><?php echo $usuario->historico ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label id="txt-user">User</label>
                                    <input type="text" name="txt-user" class="form-control"
                                           placeholder="Digite o user do usuário"
                                           value="<?php echo $usuario->user; ?>">
                                </div>
                                <div class="form-group">
                                    <label id="txt-senha">Senha</label>
                                    <input type="password" name="txt-senha" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label id="txt-confir-senha">Confirme a Senha</label>
                                    <input type="password" name="txt-confir-senha" class="form-control">
                                </div>
                                <input type="hidden" name="txt-id" id="txt-id" value="<?php echo $usuario->id?>" >
                                <button type="submit" class="btn btn-default">Salvar Alterações</button>
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
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo 'Imagem de destaque do(a) ' . $subtitulo . ' existente'; ?>
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

