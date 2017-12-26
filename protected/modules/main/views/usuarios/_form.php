<script type="text/javascript">
    function voltar() {
        window.location = '<?php echo Yii::app()->request->baseUrl; ?>/main/usuarios/index/';
    }
    $(document).ready(function() {

        $("#Usuarios_nome").keyup(function() {
            $("#Usuarios_nome").val($("#Usuarios_nome").val().toUpperCase());
        });
        // Validation            
        $("#usuarios-form").validate({
            // Rules for form validation
            rules: {
                'txtusuario': {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                'txtsenha': {
                    required: true,
                    minlength: 6,
                    maxlength: 255
                },
                'Usuarios[nome]': {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                }
            },
            // Messages for form validation
            messages: {
                'txtusuario': {
                    required: 'Digite o login',
                    minlength: 'O login deve ter no mínimo 03 caracteres',
                    maxlength: 'O login não pode ultrapassar 255 caracteres'
                },
                'txtsenha': {
                    required: 'Digite a Senha',
                    minlength: 'Sua senha deve ter no mínimo 06 caracteres',
                    maxlength: 'Sua senha não pode ultrapassar 10 caracteres'
                },
                'Usuarios[nome]': {
                    required: 'Digite o nome',
                    minlength: 'O nome deve ter no mínimo 03 caracteres',
                    maxlength: 'O nome não pode ultrapassar 255 caracteres'
                }
            },
            // Do not change code below
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent());
            },
            // Check if has error
            invalidHandler: function(event, validator) {
                var errors = validator.numberOfInvalids();
                if (errors)
                {
                    //$('#btn').attr('disabled', false).css('cursor', 'pointer');
                    //$('#loader-button').hide();
                }
            },
            submitHandler: function(form) {

                $("#btnCadastro").hide();
                $("#btnVolta").hide();
                $("#loading").show();
                $("#msgWarning").hide();
                var usuario = $("#txtusuario").val();
                var senha = $("#txtsenha").val();
                var nome = $("#Usuarios_nome").val();
                var url = "";
                if ("<?= $page; ?>" == 'create') {
                    url = "<?= Yii::app()->createAbsoluteUrl('/main/usuarios/create/') ?>";
                } else {
                    url = document.URL;
                }

                $.post(url, {usuario: usuario, senha: senha, nome: nome}, function(data) {

                    if (data.tipo == "SUCESSO") {
                        window.location = "<?= Yii::app()->createAbsoluteUrl('/main/usuarios/index/acao/' . $page) ?>";
                    } else {

                        $("#msg").html(data.msg);
                        $("#msgWarning").show();
                        $("#loading").hide();
                        $("#btnCadastro").show();
                        $("#btnVolta").show();
                    }

                }, "json");
                return false;
            }
        });
    });
</script>
<!-- RIBBON -->
<div id="ribbon" class="smart-form" >
    <span class="ribbon-button-alignment"> <span id="refresh" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Atenção! Você perderá os dados não salvos." data-html="true"><i class="fa fa-refresh"></i></span> </span>
    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>
            <?php if ($page == 'create') { ?>
                Usuário / Adicionar Novo            
            <?php } else { ?>
                Usuário / Atualizar
            <?php } ?>
        </li>
    </ol>
    <!-- end breadcrumb -->               
</div>
<!-- END RIBBON -->
<!-- MAIN CONTENT -->
<div id="content" >
    <section id="widget-grid"  >                                        

        <div class="jarviswidget" id="wid-id-6" data-widget-editbutton="false" data-widget-colorbutton="true" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                <?php if ($page == 'create') { ?>
                    <h2>Adicionar Usuário</h2>				                    
                <?php } else { ?>
                    <h2>Atualizar Usuário</h2>				                    
                <?php } ?>

            </header>           
            <!-- widget div-->
            <div>                  
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'usuarios-form',
                    'htmlOptions' => array('class' => 'smart-form'),
                    'enableAjaxValidation' => false,
                ));
                ?>
                <?php
                if (isset($msg) && !empty($msg)) {
                    ?>
                    <div id="msgSuccess" class="alert alert-success fade in">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="fa-fw fa fa-check"></i>            
                        <?php echo $msg; ?>
                    </div>
                <?php } ?>
                <div id="msgWarning" class="alert alert-warning fade in" style="display: none">
                    <button class="close" data-dismiss="alert">×</button>
                    <i class="fa-fw fa fa-warning"></i>
                    <strong>Atenção</strong><br><br>
                    <span id="msg"></span>
                </div>

                <!-- widget content -->
                <div class="widget-body no-padding">

                    <header>
                        <label class="text-danger"> Os campos com * são obrigatórios.</label>
                    </header> 
                    <fieldset>
                        <?php
                        if ($page == "create") {
                            ?>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="label">Login *</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="text" name="txtusuario" id="txtusuario">
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="label">Senha *</label>
                                    <label class="input"> <i class="icon-append fa  fa-lock"></i>
                                        <input type="password" name="txtsenha" id="txtsenha">
                                    </label>
                                </section>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <section class="col col-6">
                                <label class="label"><?php echo $form->labelEx($model, 'nome'); ?></label>
                                <label class="input"> <i class="icon-append fa  fa-user"></i>
                                    <?php echo $form->textField($model, 'nome', array('size' => 60, 'maxlength' => 255)); ?>
                                </label>
                            </section>                                                              
                        </div>    
                    </fieldset>
                    <footer>         
                        <button id="btnCadastro" type="submit" class="btn btn-primary">
                            <?php
                            if ($page == "create") {
                                ?>
                                <i class=" fa fa-check"></i>&nbsp; Cadastrar
                                <?php
                            } else {
                                ?>
                                <i class=" fa fa-refresh"></i>&nbsp; Atualizar
                                <?php
                            }
                            ?>
                        </button>
                        <img id="loading" src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" >
                        <button id="btnVolta" class="btn btn-default" onclick="voltar();" type="button"><i class=" fa fa-reply"></i>&nbsp; Voltar</button>
                    </footer>
                </div>
                <?php $this->endWidget(); ?> 
                <!-- end widget content -->
            </div>
            <!-- end widget div -->
        </div>
    </section>

    <!-- end widget -->
</div>
<!-- END MAIN CONTENT -->
