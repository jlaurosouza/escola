<script type="text/javascript">

    function oAlunoCallback(json) {

        if (!$('#main #oAlunooCallback').length)
        {
            $('#main').append('<div id="oAlunooCallback"></div>');
        }

        $('#oAlunooCallback').html(json.modal);
    }

    $(document).ready(function() {
        /*
         * Aguardando Resolução oAluno
         */
        var oAluno = $('#oAluno').dataTable({
            "sDom": "<'dt-top-row'><'dt-wrapper't><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
            "aaSorting": [[0, 'desc']],
            "oLanguage": {
                "sSearch": "Pesquisar todas as colunas:",
                "sEmptyTable": "Não há Aluno relacionados a pesquisa",
                "sInfo": "",
                "sInfoEmpty": "",
                "sInfoFiltered": "",
                "sInfoPostFix": "",
                "sLengthMenu": "_MENU_",
                "sLoadingRecords": "Aguarde...",
                "sProcessing": "Processando...",
                "sSearch" : "Pesquisar:",
                        "sZeroRecords": "Nenhum resultado.",
                "oPaginate": {
                    "sFirst": "Primeira",
                    "sPrevious": "Anterior",
                    "sNext": "Próxima",
                    "sLast": "Última"
                },
            },
            "bSortCellsTop": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo Yii::app()->createAbsoluteUrl('main/alunos/grid'); ?>",
            "sServerMethod": "POST",
            "iDisplayLength": 10,
            "fnServerData": function(sSource, aoData, fnCallback, oSettings) {

                cacheData = aoData;

                oSettings.jqXHR = $.post(sSource, cacheData, function(data) {

                    if (!parseInt(data.iTotalRecords) > 0)
                    {
                        oTableZeroRecords('#oAluno', 5);
                        $('.customPage.oAluno').fadeOut(500);
                    }

                    else
                    {
                        $('.customPagination.oAluno').children('label').children('input').attr('disabled', false).val(data.iDisplayStart);
                        $('.customPagination.oAluno').children('span').html(Math.ceil(parseInt(data.iTotalRecords) / parseInt(data.iDisplayLength)));
                        $('.customPagination.oAluno').children('button').attr('disabled', false).css('cursor', 'pointer').html('<i class="fa fa-arrow-circle-right"></i> Ir a Página');
                        $('.customPagination.oAluno').fadeIn(500);
                    }

                    fnCallback(data);
                    oAlunoCallback(data);

                }, 'json');
            }
        });

         /* ==== CARREGAR O GRID ATRAVEZ DA AÇÃO DO DROPDOWNLIST ==== */
        $("#ddlsearch_status_aluno").change(function() {

            clearTimeout(oAlunoClearTimeout);
            oAlunoClearTimeout = setTimeout(function() {

                oTableCustomLoader('#ddlsearch_status_aluno', 5);
                var oSettings = oAluno.fnSettings();
                for (iCol = 0;
                        iCol < oSettings.aoPreSearchCols.length;
                        iCol++) {
                    oSettings.aoPreSearchCols[iCol].sSearch = '';
                }

                oSettings.aoPreSearchCols[3].sSearch = $("#ddlsearch_status_aluno").val();
                oAluno.fnDraw();

            }, 1000);
        });
        /* ==== FIM CARREGAR O GRID ATRAVEZ DA AÇÃO DO DROPDOWNLIST ==== */


        var oAlunoClearTimeout = null;
        /* Add the events etc before DataTables hides a column */
        $("#oAluno thead input").keyup(function() {

            var that = this;
            clearTimeout(oAlunoClearTimeout);
            oAlunoClearTimeout = setTimeout(function() {

                oTableCustomLoader('#oAluno', 5);

                var oSettings = oAluno.fnSettings();
                for (iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
                    oSettings.aoPreSearchCols[ iCol ].sSearch = '';
                }
                //oAluno.fnDraw();
                oAluno.fnFilter(that.value, oAluno.oApi._fnVisibleToColumnIndex(oAluno.fnSettings(), $("#oAluno thead input").index(that)));

            }, 500);

        });

        $("#oAluno thead input").each(function(i) {
            this.initVal = this.value;
        });
        $("#oAluno thead input").focus(function() {
            if (this.className == "search_init") {
                this.className = "";
                this.value = "";

                $("#oAluno thead input").not(this).val('');
            }
        });
        $("#oAluno thead input").blur(function(i) {
            if (this.value == "") {
                this.className = "search_init";
                this.value = this.initVal;

                $("#oAluno thead input").not(this).val(this.initVal);
            }
        });

        //oAluno.fnDraw();

        $('.customPagination').submit(function(e) {

            var _input = $(this).children('label').children('input');
            var _button = $(this).children('button');
            var _targetPage = _input.val().length > 0 ? parseInt(_input.val()) - 1 : 0;

            _input.attr('disabled', true);
            _button.attr('disabled', true).css('cursor', 'wait').html('<i class="fa fa-refresh fa-spin"></i> Carregando...');

            if ($(this).hasClass('oAluno'))
            {
                oTableCustomLoader('#oAluno', 5);
                oAluno.fnPageChange(_targetPage, true);
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
            Alunos
        </li>
    </ol>
    <!-- end breadcrumb -->               
</div>
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa-fw fa fa-book"></i>
                Alunos
                <span>> Lista das Alunos </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-7">           
            <a class="btn btn-primary btn-lg pull-right header-btn hidden-mobile " data-toggle="modal" href="<?= Yii::app()->createAbsoluteUrl('main/alunos/create'); ?>">
                <i class="fa fa-plus"></i>
                Adicionar Novo Aluno
            </a>             
        </div>
    </div>
    <section id="widget-grid"  >   
        <div class="jarviswidget" id="wid-id-6" data-widget-editbutton="false" data-widget-colorbutton="true" 
             data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-list-ul"></i> </span>
                <h2>Todos as Alunos</h2>				                    
            </header>
            <!-- widget div-->
            <!--<div>-->  
            <?php
            if ($_GET) {
                if (isset($_GET['acao']) && $_GET['acao'] == "create") {
                    $msg = "Aluno cadastrada com sucesso!";
                } elseif (isset($_GET['acao']) && $_GET['acao'] == "update") {
                    $msg = "Aluno atualizada com sucesso!";
                } elseif (isset($_GET['acao']) && $_GET['acao'] == "delete") {
                    $msg = "Aluno removido com sucesso!";
                } elseif (isset($_GET['acao']) && $_GET['acao'] == "inactivate") {
                    $msg = "Aluno inativada com sucesso!";
                } elseif (isset($_GET['acao']) && empty($_GET['acao'])) {
                    $this->redirect(Yii::app()->createAbsoluteUrl('main/alunos/index'));
                }
            }
            ?>
            <!-- INICIO DA DATATABLE -->
            <div class="row">
                <?php
                if (isset($erro) && !empty($erro)) {
                    ?>
                    <div class="alert alert-warning fade in">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="fa-fw fa fa-warning"></i>  
                        <strong>Atenção!</strong><br><br>
                        <?php echo $erro; ?>
                    </div>
                    <?php
                } elseif (isset($msg) && !empty($msg)) {
                    ?>
                    <div class="alert alert-success fade in">
                        <button class="close" data-dismiss="alert"> × </button>
                        <i class="fa-fw fa fa-check"></i>            
                        <?php echo $msg; ?>
                    </div>
                    <?php
                }
                ?>                

                <table id="oAluno" class="table table-striped table-bordered smart-form " >
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th class="style-table-cnpj-acoes">CPF</th>
                            <th>CIDADE</th>
                            <th>STATUS</th>                            
                            <th class="style-table-two-acoes">AÇÕES </th>
                        </tr>
                        <tr class="second">                               
                            <td>     
                                <label class="input">
                                    <input type="text" name="search_nome_aluno" placeholder="Nome" class="seach_init">
                                </label>
                            </td>
                            <td>     
                                <label class="input">
                                    <input type="text" name="search_cpf_aluno" placeholder="CPF" class="seach_init">
                                </label>
                            </td>
                            <td>     
                                <label class="input">
                                    <input type="text" name="search_cidade_aluno" placeholder="Cidade" class="seach_init">
                                </label>
                            </td> 
                            <td>     
                                <label class="select">
                                    <i></i><select type="text" id="ddlsearch_status_aluno" name="ddlsearch_status_aluno" class="seach_init"/>
                                    <option value="A">Ativo</option>
                                    <option value="I">Inativo</option>
                                    </select>
                                </label>
                            </td>
                            <td><!-- ações --></td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <br/>
            </div>
            <!-- FIM DA DATATABLE -->
            <!--</div>-->

        </div>
    </section>
</div>
<script>
    function inativar(id) {
        $.SmartMessageBox({
            title: "<span><i class='fa fa-ban txt-color-red' ></i><strong class='txt-color-orange'> Inativar</strong></span>",
            content: "Deseja inativar esto aluno?",
            buttons: '[Não][Sim]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Sim") {
                $.smallBox({
                    title: "<i class='fa fa-spinner fa-spin'></i> Aguarde...",
                    content: "<i>Estamos inativando o aluno, <br />Este processo pode demorar um pouco</i>",
                    color: "#3276B1",
                    iconSmall: "fa fa-clock-o fa-2x fadeInRight animated",
                    timeout: 99999//4000
                });
                window.location = '<?= Yii::app()->createAbsoluteUrl("main/alunos/inactivate/id") ?>/' + id;
            }
        });
    }
</script>