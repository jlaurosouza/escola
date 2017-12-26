<script type="text/javascript">

    //Adicionando novas Tags para telefone
    $(document).ready(function() {
        $("#bntaddFone").click(function() {

            var cont = 0;
            var sair = 0;

            //adicionar próximo componento do conjunto Array
            do {
                if ($("#txtFone_" + cont).length) {
                    cont++;
                } else {
                    sair = 1;
                    break;
                }
            } while (sair === 0);

            $('#itens').append("<div class='row'><section class='col col-2'> " +
                    "<label class='label'>Novo telefone</label>" +
                    "<div class='input'><i class='icon-append fa fa-phone'></i>" +
                    "<input id='txtFone_" + cont + "' class='fone' name='txtFone[" + cont + "]' type='text' onkeyup='mascaraTelefone(\"" + cont + "\")'>" +
                    "</div></section><section class='col col-2'><label class='label'>Operadora</label>" +
                    "<label class='select'> <i class='icon-append fa'></i>" +
                    "<?php $modelOperadora = Operadoras::model()->findAll(); ?>" +
                    "<select name='ddlOperadora[" + cont + "]' id='ddlOperadora_" + cont + "' empty='Selecione' class='select2'>" +
                    "<?php foreach ($modelOperadora as $list) { ?>" +
                    "<option value='<?php echo $list->id; ?>'><?php echo $list->descricao; ?></option>" +
                    "<?php } ?>" +
                    "</select></label></section></div>");

            $("#txtFone_" + cont).focus();
        });
    });
    function mascaraTelefone(cont) {
        $("#txtFone_" + cont).val(Util.mascaraTelefone($("#txtFone_" + cont).val()));
    }
    $(function() {

        $('#Alunos_estado').change(function() {
            if ($(this).val()) {
                $("#Alunos_cidade").html("");
                $(".ddlcidade .select2-choice .select2-chosen").html("carregando...");
                $.getJSON("<?= Yii::app()->createAbsoluteUrl('/main/default/carregarCidades/') ?>", {codigoEstado: $(this).val(), ajax: 'true'}, function(j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].id + '">' + j[i].cidade + '</option>';
                    }
                    $(".ddlcidade .select2-choice .select2-chosen").html("");
                    $('#Alunos_cidade').html(options).show();
                    $(".ddlcidade .select2-choice .select2-chosen").html("Selecione");
                });
            } else {
                $(".ddlcidade .select2-choice .select2-chosen").html("");
                $('#Alunos_cidade').html('<option value="">-- Escolha um estado --</option>');
            }
        });


        $("#Alunos_nome").keyup(function() {
            $("#Alunos_nome").val($("#Alunos_nome").val().toUpperCase());
        });

        $("#Alunos_bairro").keyup(function() {
            $("#Alunos_bairro").val($("#Alunos_bairro").val().toUpperCase());
        });

        $("#Alunos_rua").keyup(function() {
            $("#Alunos_rua").val($("#Alunos_rua").val().toUpperCase());
        });

        $("#Alunos_numero").keyup(function() {
            $("#Alunos_numero").val($("#Alunos_numero").val().toUpperCase());
        });

        $("#Alunos_complemento").keyup(function() {
            $("#Alunos_complemento").val($("#Alunos_complemento").val().toUpperCase());
        });


        // Validation            
        $("#alunos-form").validate({
            // Rules for form validation
            rules: {
                'Alunos[nome]': {
                    required: true,
                    minlength: 6,
                    maxlength: 100
                },
                'Alunos[cpf]': {
                    required: true,
                    minlength: 11
                },
                'Alunos[email]': {
                    required: true,
                    email: true
                },
                'Alunos[estado]': {
                    required: true
                },
                'Alunos[cidade]': {
                    required: true
                },
                'Alunos[cep]': {
                    required: true,
                    minlength: 10
                },
                'Alunos[bairro]': {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                'Alunos[rua]': {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                'Alunos[numero]': {
                    required: true,
                    minlength: 1,
                    maxlength: 10
                }
            },
            // Messages for form validation
            messages: {
                'Alunos[nome]': {
                    required: 'Digite a Razão social',
                    minlength: 'A Razão social deve ter no mínimo 06 caracteres',
                    maxlength: 'A Razão social não pode ultrapassar 100 caracteres'
                },
                'Alunos[cpf]': {
                    required: 'Digite o CNPJ',
                    minlength: 'O CNPJ deve conter exatamente 11 caracteres'
                },
                'Alunos[email]': {
                    required: 'Informa o e-mail',
                    email: 'Informe um e-mail válido'
                },
                'Alunos[estado]': {
                    required: 'Escolha um estado'
                },
                'Alunos[cidade]': {
                    required: 'Escolha uma cidade'
                },
                'Alunos[cep]': {
                    required: 'Informe o CEP',
                    minlength: 'O CEP deve conter exatamente 10 caracteres ex: 123.567-90'                
                },
                'Alunos[bairro]': {
                    required: 'Digite o Bairro',
                    minlength: 'O Bairro deve ter no mínimo 03 caracteres',
                    maxlength: 'O Bairro não pode ultrapassar 255 caracteres'
                },
                'Alunos[rua]': {
                    required: 'Digite o Logradouro',
                    minlength: 'O Logradouro deve ter no mínimo 03 caracteres',
                    maxlength: 'O Logradouro não pode ultrapassar 255 caracteres'
                },
                'Alunos[numero]': {
                    required: 'Digite o Número, se não existir digite: S/N',
                    minlength: 'O Número deve ter no mínimo 01 caracteres',
                    maxlength: 'O Número não pode ultrapassar 255 caracteres'
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

                var nome = $("#Alunos_nome").val();
                var email = $("#Alunos_email").val();
                var cpf = $("#Alunos_cpf").val();
                var cep = $("#Alunos_cep").val();
                var estado = $("#Alunos_estado").val();
                var cidade = $("#Alunos_cidade").val();
                var bairro = $("#Alunos_bairro").val();
                var rua = $("#Alunos_rua").val();
                var numero = $("#Alunos_numero").val();
                var complemento = $("#Alunos_complemento").val();

                //conjunto Array
                var fones = new Array();
                var operadoras = new Array();

                var cont = 0;
                var sair = 0;

                do {
                    if ($("#txtFone_" + cont).length) {
                        fones[cont] = $("#txtFone_" + cont).val();
                        operadoras[cont] = $("#ddlOperadora_" + cont).val();
                        cont++;
                    } else {
                        sair = 1;
                        break;
                    }
                } while (sair === 0);


                if ("<?= $page; ?>" == 'create') {
                    url = "<?= Yii::app()->createAbsoluteUrl('/main/alunos/create/') ?>";
                } else {
                    url = document.URL;
                }

                $.post(url, {nome: nome, email: email, cpf: cpf, estado: estado, cidade: cidade, bairro: bairro,
                    cep: cep, rua: rua, numero: numero, complemento: complemento, fones: fones, operadoras: operadoras},
                function(data) {

                    if (data.tipo == "SUCESSO") {
                        if (typeof data.user == "undefined") {
                            window.location = "<?= Yii::app()->createAbsoluteUrl('/main/alunos/index/acao/' . $page) ?>";
                        } else {
                            window.location = "<?= Yii::app()->createAbsoluteUrl('/main/alunos/index/acao/' . $page) ?>" + "/user/" + data.user + "/pwd/" + data.pwd;
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

        $("#Alunos_cep").mask("99.999-999");
        $("#Alunos_cpf").mask("999.999.999-99");
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
                    'id' => 'alunos-form',
                    'htmlOptions' => array('class' => 'smart-form'),
                    'enableAjaxValidation' => false,
                ));
                ?>      
                <?php
                if ($_GET) {
                    if (isset($_GET['msg']) && empty($_GET['msg'])) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('main/alunos/index'));
                    } elseif (isset($_GET['id']) && empty($_GET['id'])) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('main/alunos/index'));
                    } elseif (!isset($_GET['msg']) && !isset($_GET['id'])) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('main/alunos/index'));
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
                                    <label class="label"><?php echo $form->labelEx($model, 'nome'); ?></label>
                                </label>
                                <label class="input"> <i class="icon-append fa fa-book"></i>
                                    <?php echo $form->textField($model, 'nome', array('size' => 60, 'maxlength' => 255)); ?>                                  
                                </label>
                            </section> 
                            <section class="col col-4">
                                <label class="label"><?php echo $form->labelEx($model, 'cpf'); ?></label>
                                <label class="input"> <i class="icon-append fa  fa-list-alt"></i>
                                    <?php echo $form->textField($model, 'cpf', array('size' => 60, 'maxlength' => 255)); ?>                                    
                                </label>
                            </section>   
                            <section class="col col-4">
                                <label class="label" id="Nome_Fantasia">E-mail *</label>
                                <label class="input"> <i class="icon-append fa fa-envelope"></i>
                                    <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>                             
                                </label>
                            </section> 
                        </div>
                        <div class="row"> 
                            <section class="col col-4">
                                <label class="label">
                                    <label class="label"><?php echo $form->labelEx($model, 'cep'); ?> <label style="color: green;"><b>(Busca automática)</b></label>
                                    </label>
                                </label>
                                <label class="input">
                                    <i class="icon-append">
                                        <i id="iconLoadBusca" style="display: none;" class="fa fa-spinner fa-spin txt-color-red"></i>
                                        <i id="iconBuscaCep" class=" fa fa-globe fa-spin  txt-color-green" title="Click para fazer a Busca do endereço através do CEP informado!" href="javascript:void(0);" onclick="BuscarCEP();"></i>                                        
                                    </i>                                    
                                    <?php echo $form->textField($model, 'cep', array('size' => 60, 'maxlength' => 255)); ?>                                  

                                </label>
                            </section>                                                    
                            <section class="col col-4">
                                <label class="label"><?php echo $form->labelEx($model, 'estado'); ?></label>
                                <label class="select"> <i></i>
                                    <?php
                                    $modelEstado = Estado::model()->findAll();

                                    $list = CHtml::listdata($modelEstado, "id", "nome");
                                    ?>
                                    <?php echo $form->dropDownList($model, 'estado', $list, array('empty' => 'Selecione', 'onchange' => 'carregarCidades()', 'class' => 'select2 ddlestado')); ?>                                                              
                                </label>
                            </section>    
                            <section class="col col-4">
                                <label class="label"><?php echo $form->labelEx($model, 'cidade'); ?></label>
                                <label class="select"> <i></i>
                                    <?php
                                    $list = array();
                                    if ($page == "update") {
                                        $criteria = new CDbCriteria;
                                        $criteria->condition = "idestado = :estado";
                                        $criteria->params = array(":estado" => $model->estado);

                                        $cidade = Cidade::model()->findAll($criteria);
                                        $list = CHtml::listdata($cidade, "id", "nome");
                                    }
                                    ?>
                                    <?php echo $form->dropDownList($model, 'cidade', $list, array('class' => 'select2 ddlcidade'), array('empty' => '')); ?>                                     
                                </label>                                
                            </section>    
                        </div>                        
                        <div class="row">                               
                            <section class="col col-4">
                                <label class="label"><?php echo $form->labelEx($model, 'bairro'); ?></label>
                                <label class="input"> <i class="icon-append fa fa-home"></i>
                                    <?php echo $form->textField($model, 'bairro', array('size' => 60, 'maxlength' => 255)); ?>                                
                                </label>
                            </section>                                 
                            <section class="col col-4">
                                <label class="label"><?php echo $form->labelEx($model, 'rua'); ?></label>
                                <label class="input"> <i class="icon-append fa fa-home"></i>
                                    <?php echo $form->textField($model, 'rua', array('size' => 60, 'maxlength' => 255)); ?>                              
                                </label>
                            </section>                           
                            <section class="col col-4">
                                <label class="label"><?php echo $form->labelEx($model, 'numero'); ?></label>
                                <label class="input"> <i class="icon-append fa fa-home"></i>
                                    <?php echo $form->textField($model, 'numero', array('size' => 60, 'maxlength' => 255)); ?>
                                </label>
                            </section>    
                        </div>
                        <div class="row">
                            <section class="col col-lg-12">
                                <label class="label"><?php echo $form->labelEx($model, 'complemento'); ?></label>
                                <label class="input"> <i class="icon-append fa fa-home"></i>
                                    <?php echo $form->textField($model, 'complemento', array('size' => 60, 'maxlength' => 255)); ?>                             
                                </label>
                            </section>  
                        </div>
                        <?php
                        if ($page == 'create') {
                            ?>
                            <div class="row">
                                <section class="col col-2">
                                    <label class="label">Telefones</label>
                                    <div class="input">
                                        <i class="icon-append fa fa-phone"></i>
                                        <input id="txtFone_0" class="fone" name="txtFone[0]" type="text" onkeyup='mascaraTelefone("0")'>                                    
                                    </div>
                                </section> 
                                <section class="col col-2">
                                    <label class="label">Operadora</label>
                                    <label class="select"> <i class="icon-append fa"></i>
                                        <?php
                                        $modelOperadora = Operadoras::model()->findAll();
                                        $list = CHtml::listdata($modelOperadora, "id", "descricao");
                                        ?>
                                        <?php echo CHtml::dropDownList('ddlOperadora[0]', '', $list, array('id' => 'ddlOperadora_0')); ?>
                                    </label>
                                </section>   
                                <section class="col">
                                    &nbsp;
                                    <div class="input" >
                                        <span class="button" nome="bntaddFone" id="bntaddFone" ><i class="fa fa-phone"></i>&nbsp;&nbsp;Adicionar</span>
                                    </div>
                                </section>
                            </div>
                        <?php } ?>
                        <!-- Adicionando Tags Telefones se '$Page == Update' -->
                        <?php
                        if ($page == 'update') {
                            $criteria = new CDbCriteria;
                            $criteria->condition = "idaluno=:idaluno";
                            $criteria->params = array(":idaluno" => $model->id);

                            $cont = Telefones::model()->count($criteria);

                            //Se não houver Ocorrência, incluir o padrão (telefone, operador e buton 'adcionar')
                            if ($cont == 0) {
                                ?>
                                <div class="row">
                                    <section class="col col-2">
                                        <label class="label">Telefones</label>
                                        <div class="input">
                                            <i class="icon-append fa fa-phone"></i>
                                            <input id="txtFone_0" class="fone" name="txtFone[0]" type="text" onkeyup='mascaraTelefone("0")'>                                    
                                        </div>
                                    </section> 
                                    <section class="col col-2">
                                        <label class="label">Operadora</label>
                                        <label class="select"> <i class="icon-append fa"></i>
                                            <?php
                                            $modelOperadora = Operadoras::model()->findAll();
                                            $list = CHtml::listdata($modelOperadora, "id", "descricao");
                                            ?>
                                            <?php echo CHtml::dropDownList('ddlOperadora[0]', '', $list, array('id' => 'ddlOperadora_0')); ?>
                                        </label>
                                    </section>   
                                    <section class="col">
                                        &nbsp;
                                        <div class="input" >
                                            <span class="button" nome="bntaddFone" id="bntaddFone" ><i class="fa fa-phone"></i>&nbsp;&nbsp;Adicionar</span>
                                        </div>
                                    </section>
                                </div>
                                <?php
                            } else {
                                //se hover ocorrência Adciona Campos referênte a quantidade das ocorrências
                                $cont = 0;
                                $fones = Telefones::model()->findAll($criteria);
                                foreach ($fones as $fn) {
                                    ?>
                                    <div class="row">
                                        <section class="col col-2">
                                            <label class="label">Telefones</label>
                                            <div class="input">
                                                <i class="icon-append fa fa-phone"></i>
                                                <input id="txtFone_<?php echo $cont; ?>" name="txtFone[<?php echo $cont; ?>]" type="text" value="<?php echo $fn->numero; ?>"  onkeyup='mascaraTelefone("<?php echo $cont ?>")'>                                    
                                            </div>
                                        </section> 
                                        <section class="col col-2">
                                            <label class="label">Operadora</label>
                                            <label class="select"> <i class="icon-append fa"></i>
                                                <?php
                                                $modelOperadora = Operadoras::model()->findAll();
                                                $list = CHtml::listdata($modelOperadora, "id", "descricao");
                                                ?>
                                                <?php echo CHtml::dropDownList('ddlOperadora[' . $cont . ']', '', $list, array('id' => 'ddlOperadora_' . $cont, 'options' => array($fn->idoperadora => array('selected' => true)))); ?>
                                            </label>
                                        </section>  
                                        <?php if ($cont == 0) { ?>
                                            <section class="col">
                                                &nbsp;
                                                <div class="input" >
                                                    <span class="button" nome="bntaddFone" id="bntaddFone" ><i class="fa fa-phone"></i>&nbsp;&nbsp;Adicionar</span>
                                                </div>
                                            </section>
                                        <?php } ?>
                                    </div>
                                    <?php
                                    $cont++;
                                }
                            }
                        }
                        ?>
                        <!-- Fim da Adição de Tags telefones -->
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
        window.location = '<?php echo Yii::app()->request->baseUrl; ?>/main/alunos/index/';
    }

    function BuscarCEP() {
        $("#msgWarning").hide();
        $("#iconBuscaCep").hide();
        $("#iconLoadBusca").show();

        var msgPesquisaCep = $('#msgPesquisaCep');
        msgPesquisaCep.dialog({
            modal: true
        });


        $(".ui-dialog-titlebar-close").hide();

        cep = $("#Alunos_cep").val();

        if (cep.length > 0) {
            cep = Util.limparCaracteres(cep);
            $.post("<?= Yii::app()->createAbsoluteUrl('/main/default/buscarcep/') ?>", {cep: cep}, function(data) {

                if (data.resultado == 1) {

                    $("#Alunos_estado option[value='" + data.iduf + "']").attr("selected", true);
                    $(".ddlestado .select2-choice .select2-chosen").html(data.uf);

                    $("#Alunos_cidade").html("");
                    $("#Alunos_cidade").append("<option value='" + data.idcidade + "'>" + data.cidade + "</option>").attr("selected", true);
                    $(".ddlcidade .select2-choice .select2-chosen").html(data.cidade);

                    $("#Alunos_bairro").val(data.bairro);
                    $("#Alunos_rua").val(data.tipo_logradouro + " " + data.logradouro);

                    $("#msgPesquisaCep").dialog('close');
                    $("#iconLoadBusca").hide();
                    $("#iconBuscaCep").show();

                } else {
                    $("#msgPesquisaCep").dialog('close');
                    $("#msg").html(data.resultado_txt);
                    $("#msgWarning").show();
                    $("#iconLoadBusca").hide();
                    $("#iconBuscaCep").show();
                }
            }, "json");
        } else {
            $("#msgPesquisaCep").dialog('close');
            $("#iconLoadBusca").hide();
            $("#iconBuscaCep").show();
        }

    }

</script>
<div id="msgPesquisaCep" style="display: none" title="&nbsp; &nbsp; &nbsp; Pesquisando, Aguarde...">
    <center><img style="width: 50%;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading-icon.gif" ></center>    
</div>