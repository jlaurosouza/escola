<script type="text/javascript">

    function oCursoCallback(json) {

        if (!$('#main #oCursooCallback').length)
        {
            $('#main').append('<div id="oCursooCallback"></div>');
        }

        $('#oCursooCallback').html(json.modal);
    }

    $(document).ready(function() {
        /*
         * Aguardando Resolução oCurso
         */
        var oCurso = $('#oCurso').dataTable({
            "sDom": "<'dt-top-row'><'dt-wrapper't><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
            "aaSorting": [[0, 'desc']],
            "oLanguage": {
                "sSearch": "Pesquisar todas as colunas:",
                "sEmptyTable": "Não há Curso relacionados a pesquisa",
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
            "sAjaxSource": "<?php echo Yii::app()->createAbsoluteUrl('main/cursos/grid'); ?>",
            "sServerMethod": "POST",
            "iDisplayLength": 10,
            "fnServerData": function(sSource, aoData, fnCallback, oSettings) {

                cacheData = aoData;

                oSettings.jqXHR = $.post(sSource, cacheData, function(data) {

                    if (!parseInt(data.iTotalRecords) > 0)
                    {
                        oTableZeroRecords('#oCurso', 5);
                        $('.customPage.oCurso').fadeOut(500);
                    }

                    else
                    {
                        $('.customPagination.oCurso').children('label').children('input').attr('disabled', false).val(data.iDisplayStart);
                        $('.customPagination.oCurso').children('span').html(Math.ceil(parseInt(data.iTotalRecords) / parseInt(data.iDisplayLength)));
                        $('.customPagination.oCurso').children('button').attr('disabled', false).css('cursor', 'pointer').html('<i class="fa fa-arrow-circle-right"></i> Ir a Página');
                        $('.customPagination.oCurso').fadeIn(500);
                    }

                    fnCallback(data);
                    oCursoCallback(data);

                }, 'json');
            }
        });

         /* ==== CARREGAR O GRID ATRAVEZ DA AÇÃO DO DROPDOWNLIST ==== */
        $("#ddlsearch_status_curso").change(function() {

            clearTimeout(oCursoClearTimeout);
            oCursoClearTimeout = setTimeout(function() {

                oTableCustomLoader('#ddlsearch_status_curso', 5);
                var oSettings = oCurso.fnSettings();
                for (iCol = 0;
                        iCol < oSettings.aoPreSearchCols.length;
                        iCol++) {
                    oSettings.aoPreSearchCols[iCol].sSearch = '';
                }

                oSettings.aoPreSearchCols[3].sSearch = $("#ddlsearch_status_curso").val();
                oCurso.fnDraw();

            }, 1000);
        });
        /* ==== FIM CARREGAR O GRID ATRAVEZ DA AÇÃO DO DROPDOWNLIST ==== */


        var oCursoClearTimeout = null;
        /* Add the events etc before DataTables hides a column */
        $("#oCurso thead input").keyup(function() {

            var that = this;
            clearTimeout(oCursoClearTimeout);
            oCursoClearTimeout = setTimeout(function() {

                oTableCustomLoader('#oCurso', 5);

                var oSettings = oCurso.fnSettings();
                for (iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
                    oSettings.aoPreSearchCols[ iCol ].sSearch = '';
                }
                //oCurso.fnDraw();
                oCurso.fnFilter(that.value, oCurso.oApi._fnVisibleToColumnIndex(oCurso.fnSettings(), $("#oCurso thead input").index(that)));

            }, 500);

        });

        $("#oCurso thead input").each(function(i) {
            this.initVal = this.value;
        });
        $("#oCurso thead input").focus(function() {
            if (this.className == "search_init") {
                this.className = "";
                this.value = "";

                $("#oCurso thead input").not(this).val('');
            }
        });
        $("#oCurso thead input").blur(function(i) {
            if (this.value == "") {
                this.className = "search_init";
                this.value = this.initVal;

                $("#oCurso thead input").not(this).val(this.initVal);
            }
        });

        //oCurso.fnDraw();

        $('.customPagination').submit(function(e) {

            var _input = $(this).children('label').children('input');
            var _button = $(this).children('button');
            var _targetPage = _input.val().length > 0 ? parseInt(_input.val()) - 1 : 0;

            _input.attr('disabled', true);
            _button.attr('disabled', true).css('cursor', 'wait').html('<i class="fa fa-refresh fa-spin"></i> Carregando...');

            if ($(this).hasClass('oCurso'))
            {
                oTableCustomLoader('#oCurso', 5);
                oCurso.fnPageChange(_targetPage, true);
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
            Cursos
        </li>
    </ol>
    <!-- end breadcrumb -->               
</div>
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa-fw fa fa-book"></i>
                Cursos
                <span>> Lista das Cursos </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-7">           
            <a class="btn btn-primary btn-lg pull-right header-btn hidden-mobile " data-toggle="modal" href="<?= Yii::app()->createAbsoluteUrl('main/cursos/create'); ?>">
                <i class="fa fa-plus"></i>
                Adicionar Novo Curso
            </a>             
        </div>
    </div>
    <section id="widget-grid"  >   
        <div class="jarviswidget" id="wid-id-6" data-widget-editbutton="false" data-widget-colorbutton="true" 
             data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-list-ul"></i> </span>
                <h2>Todos as Cursos</h2>				                    
            </header>
            <!-- widget div-->
            <!--<div>-->  
            <?php
            if ($_GET) {
                if (isset($_GET['acao']) && $_GET['acao'] == "create") {
                    $msg = "Curso cadastrada com sucesso!";
                } elseif (isset($_GET['acao']) && $_GET['acao'] == "update") {
                    $msg = "Curso atualizada com sucesso!";
                } elseif (isset($_GET['acao']) && $_GET['acao'] == "delete") {
                    $msg = "Curso removido com sucesso!";
                } elseif (isset($_GET['acao']) && $_GET['acao'] == "inactivate") {
                    $msg = "Curso inativada com sucesso!";
                } elseif (isset($_GET['acao']) && empty($_GET['acao'])) {
                    $this->redirect(Yii::app()->createAbsoluteUrl('main/cursos/index'));
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

                <table id="oCurso" class="table table-striped table-bordered smart-form " >
                    <thead>
                        <tr>
                            <th>DESCRIÇÃO</th>
                            <th class="style-table-cnpj-acoes">VALOR</th>
                           <th class="style-table-two-acoes">AÇÕES </th>
                        </tr>
                        <tr class="second">                               
                            <td>     
                                <label class="input">
                                    <input type="text" name="search_descricao_curso" placeholder="Descrição" class="seach_init">
                                </label>
                            </td>
                            <td>     
                                <label class="input">
                                    <input type="text" name="search_valor_curso" placeholder="Valor" class="seach_init">
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
            content: "Deseja inativar esto curso?",
            buttons: '[Não][Sim]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Sim") {
                $.smallBox({
                    title: "<i class='fa fa-spinner fa-spin'></i> Aguarde...",
                    content: "<i>Estamos inativando o curso, <br />Este processo pode demorar um pouco</i>",
                    color: "#3276B1",
                    iconSmall: "fa fa-clock-o fa-2x fadeInRight animated",
                    timeout: 99999//4000
                });
                window.location = '<?= Yii::app()->createAbsoluteUrl("main/cursos/inactivate/id") ?>/' + id;
            }
        });
    }
</script>