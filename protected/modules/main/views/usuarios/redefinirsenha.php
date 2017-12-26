<script>

    $(function() {
        // Validation	
        $('#usuarios-form').validate({
            // Rules for form validation
            rules: {
                'senhaatual': {
                    required: true,
                    minlength: 6,
                },
                'novasenha': {
                    required: true,
                    minlength: 6,
                },
                'cnovasenha': {
                    required: true,
                    minlength: 6,
                }
            },
            // Messages for form validation
            messages: {
                'senhaatual': {
                    required: 'Digite sua senha atual',
                    minlength: 'A senha atual deve ter no mínimo 06 caracteres',
                },
                'novasenha': {
                    required: 'Digite a nova senha',
                    minlength: 'Sua nova senha deve ter no mínimo 06 caracteres',
                },
                'cnovasenha': {
                    required: 'Redigite o nova senha',
                    minlength: 'Sua confirmação de senha deve ter no mínimo 06 caracteres',
                }
            },
            // Do not change code below
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent());
                $("#loading").hide();
                $("#btnRedefinir").show();
            },
            // Check if has error
            invalidHandler: function(event, validator) {
                var errors = validator.numberOfInvalids();
                if (errors)
                {
                    $("#loading").hide();                    
                    $("#btnRedefinir").show();
                    $("#btnVoltar").show();
                    //$('#btn').attr('disabled',false).css('cursor','pointer');
                    //$('#loader-button').hide();
                }
            }
        });
    });
</script>
<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> <span id="refresh" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Atenção! Você perderá os dados não salvos." data-html="true"><i class="fa fa-refresh"></i></span> </span>
    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>
            Usuário / Redefinir Senha
        </li>
    </ol>
    <!-- end breadcrumb -->               
</div>
<!-- END RIBBON -->
<!-- MAIN CONTENT -->
<div id="content">
    <section id="widget-grid" class="">                                        

        <div class="jarviswidget" id="wid-id-6" data-widget-editbutton="false" data-widget-colorbutton="true" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                <h2>Redefinir Senha</h2>				                    
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

                <?php if (!empty($listaError)) { ?>
                    <div class="alert alert-warning fade in">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="fa-fw fa fa-warning"></i>
                        <strong>Atenção!</strong><br><br>                        
                        <?php echo $listaError; ?>
                    </div>
                <?php } ?>

                <?php if (!empty($msg)) { ?>
                    <div class="alert alert-success fade in">
                        <button class="close" data-dismiss="alert"> × </button>                       
                        <i class="fa-fw fa fa-check"></i>
                        <?php echo $msg["msg"]; ?>
                    </div>
                <?php } ?>

                <!-- widget content -->
                <div class="widget-body no-padding">

                    <header>
                        Os campos com * são obrigatórios.
                    </header> 

                    <fieldset>
                        <div class="row">
                            <section class="col col-4">
                                <label class="label">Senha Atual *</label>
                                <label class="input"> <i class="icon-append fa  fa-lock"></i>
                                    <?php echo CHtml::passwordField('senhaatual', '', array('required' => 'required')); ?>
                                </label>
                            </section>                             
                            <section class="col col-4">
                                <label class="label">Nova Senha *</label>
                                <label class="input"> <i class="icon-append fa  fa-lock"></i>
                                    <?php echo CHtml::passwordField('novasenha', '', array('required' => 'required')); ?>
                                </label>
                            </section> 
                            <section class="col col-4">
                                <label class="label">Confirma Senha *</label>
                                <label class="input"> <i class="icon-append fa  fa-lock"></i>
                                    <?php echo CHtml::passwordField('cnovasenha', '', array('required' => 'required')); ?>
                                </label>
                            </section> 
                        </div>   
                    </fieldset>

                    <footer>                        
                        <button id="btnRedefinir" type="submit" class="btn btn-primary" onclick="redefinir();"><i class=" fa fa-refresh"></i>&nbsp; Redefinir</button>
                        <img id="loading" src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" >
                        <button id="btnVolta" class="btn btn-default" onclick="voltar();" type="button"><i class=" fa fa-reply"></i>&nbsp; Voltar</button>
                    </footer>

                </div>                    
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </section>
</div>    
<script>
    function voltar() {
        window.history.back(-1);
    }
    function redefinir() {
        $("#btnRedefinir").hide();
        $("#btnVolta").hide();
        $("#loading").show();
    }
</script>