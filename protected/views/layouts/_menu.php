<script>
    function esconderMenu() {
        $("#bodymain").addClass("hidden-menu");
        $("#left-panel").hide();
        $("#hide-menu").hide();
    }
</script>
<ul>
    <li id="default">
        <a href="<?= Yii::app()->createAbsoluteUrl('/main/default/index') ?>" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent"> Inicio</span></a>
    </li>            
    <li>
        <a href="#" class="a-cadastros"><i class="fa fa-lg fa-fw fa-pencil-square"></i> <span class="menu-item-parent"> Cadastro</span></a>
        <ul>
            <li id="alunos">
                <a href="<?= Yii::app()->createAbsoluteUrl('/main/alunos/index') ?>"><i class="fa fa-fw fa-book"></i> &nbsp; Alunos</a>
            </li>
            <li id="cursos">
                <a href="<?= Yii::app()->createAbsoluteUrl('/main/cursos/index') ?>"><i class="fa fa-fw fa-file-text"></i> &nbsp; Cursos</a>
            </li>            
        </ul>
    </li>
    <li>       
        <a href="#" class="a-usuarios"><i class="fa fa-lg fa-fw fa-unlock"></i> <span class="menu-item-parent">Acesso ao Sistema</span></a>
        <ul>
            <li id="usuarios">
                <a href="<?= Yii::app()->createAbsoluteUrl('/main/usuarios/index') ?>"><i class="fa fa-fw fa-group"></i> &nbsp; Usuários</a>
            </li>
            <li id="usuariosrd">
                <a href="<?= Yii::app()->createAbsoluteUrl('/main/usuarios/redefinirsenha/') ?>"><i class="fa fa-fw fa-key"></i> &nbsp; Redefinir Senha</a>                          
            </li>           
        </ul>
    </li>   
    <li>
        <a href="#" class="a-servico"><i class="fa fa-lg fa-fw fa-suitcase"></i> <span class="menu-item-parent"> Serviço</span></a>
        <ul>           
            <li id="integracao">
                <a href="#" class="a-servico-pesquisar"><i class="fa fa-fw fa-search"></i> &nbsp; Integraçao</a>                
            </li>
            <li id="financeiro">
                <a href="#" class="a-servico-emprestimos"><i class="fa fa-fw fa-tags"></i> &nbsp; Financeiro</a>                
            </li>
        </ul>
    </li>
</ul>