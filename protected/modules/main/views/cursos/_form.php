<script type="text/javascript">

    $(function() {

    
        $("#Cursos_descricao").keyup(function() {
            $("#Cursos_descricao").val($("#Cursos_descricao").val().toUpperCase());
        });

        // Validation            
        $("#cursos-form").validate({
            // Rules for form validation
            rules: {
                'Cursos[descricao]': {
                    required: true,
                    minlength: 6,
                    maxlength: 100
                },
                'Cursos[valor]': {
                    required: true
                }
            },
            // Messages for form validation
            messages: {
                'Cursos[descricao]': {
                    required: 'Digite a Descrição',
                    minlength: 'A Descrição deve ter no mínimo 06 caracteres',
                    maxlength: 'A Descrição não pode ultrapassar 100 caracteres'
                },
                'Cursos[valor]': {
                    required: 'Digite o Valor'
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

                var descricao = $("#Cursos_descricao").val();
                var valor = $("#Cursos_valor").val();                

                if ("<?= $page; ?>" == 'create') {
                    url = "<?= Yii::app()->createAbsoluteUrl('/main/cursos/create/') ?>";
                } else {
                    url = document.URL;
                }

                $.post(url, {descricao: descricao, valor: valor},
                function(data) {

                    if (data.tipo == "SUCESSO") {
                        if (typeof data.user == "undefined") {
                            window.location = "<?= Yii::app()->createAbsoluteUrl('/main/cursos/index/acao/' . $page) ?>";
                        } else {
                            window.location = "<?= Yii::app()->createAbsoluteUrl('/main/cursos/index/acao/' . $page) ?>" + "/user/" + data.user + "/pwd/" + data.pwd;
                        }
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

<div id="ribbon" >
    <span class="ribbon-button-alignment"> <span id="refresh" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Atenção! Você perderá os dados não salvos." data-html="true"><i class="fa fa-refresh"></i></span> </span>
    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>
            <?php
            $acao = "";
            if ($page == "create") {
                $acao = "Adicionar nova";
            } else {
                $acao = "Atualizar";
            }
            ?>
            Clientes / <?= $acao; ?> Aluno
        </li>
    </ol>    
    <!-- end breadcrumb -->               
</div>
<!-- END RIBBON -->
<!-- MAIN CONTENT -->
<div id="content" >    
    <section id="widget-grid">                                        
        <div class="jarviswidget" id="wid-id-6" data-widget-editbutton="false" data-widget-colorbutton="true" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" >
            <header>
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                <h2>Adicionar Aluno</h2>				                    
            </header>
            <!-- widget div-->
            <div>    
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'cursos-form',
                    'htmlOptions' => array('class' => 'smart-form'),
                    'enableAjaxValidation' => false,
                ));
                ?>      
                <?php
                if ($_GET) {
                    if (isset($_GET['msg']) && empty($_GET['msg'])) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('main/cursos/index'));
                    } elseif (isset($_GET['id']) && empty($_GET['id'])) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('main/cursos/index'));
                    } elseif (!isset($_GET['msg']) && !isset($_GET['id'])) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('main/cursos/index'));
                    }
                }
                ?>
                <div id="msgWarning" class="alert alert-warning fade in" style="display: none">
                    <button class="close" data-dismiss="alert">×</button>
                    <i class="fa-fw fa fa-warning"></i>
                    <strong>Atenção!</strong><br><br>
                    <span id="msg"></span>
                </div>

                <!-- widget content -->
                <div class="widget-body no-padding">

                    <header>
                        Os campos com * são obrigatórios.
                    </header> 
                    <fieldset id="itens">
                        <div class="row">
                            <section class="col col-4">
                                <label class="label">
                                    <label class="label"><?php echo $form->labelEx($model, 'descricao'); ?></label>
                                </label>
                                <label class="input"> <i class="icon-append fa fa-book"></i>
                                    <?php echo $form->textField($model, 'descricao', array('size' => 60, 'maxlength' => 255)); ?>                                  
                                </label>
                            </section> 
                            <section class="col col-4">
                                <label class="label"><?php echo $form->labelEx($model, 'valor'); ?></label>
                                <label class="input"> <i class="icon-append fa  fa-list-alt"></i>
                                    <?php echo $form->textField($model, 'valor', array('size' => 60, 'maxlength' => 255)); ?>                                    
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
                                <i class="fa fa-refresh"></i>&nbsp; Atualizar
                                <?php
                            }
                            ?>
                        </button>
                        <img id="loading" src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" >
                        <button id="btnVolta" class="btn btn-default" onclick="voltar();" type="button">
                            <i class="i fa fa-mail-reply"></i>&nbsp;&nbsp;&nbsp; Voltar
                        </button>
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
<script type="text/javascript">
    function voltar() {
        window.location = '<?php echo Yii::app()->request->baseUrl; ?>/main/cursos/index/';
    }
</script>