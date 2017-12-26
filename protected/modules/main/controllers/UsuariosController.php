<?php

class UsuariosController extends Controller {
    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Verifica sé o usuário esta Logado, se não estiver rendiraciona o formulario "login/default/index.php"
     */

    public function init() {
        if ((Yii::app()->user->isGuest)) {
            $this->redirect(array("/login/default/index"));
        }
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Verifica se o usuário existe, se esta ativo e não deletado na base de dados.
     */

    public function verificarExistenciaUsuario($usuario, $id) {

        $criteria = new CDbCriteria();

        if ($id == 0) {
            $criteria->condition = "usuario=:usuario and status=:status";
            $criteria->params = array(":usuario" => $usuario, ":status" => "A");
        } else {
            $criteria->condition = "id<>:id and status=:status";
            $criteria->params = array(":usuario" => $usuario, ":id" => $id, ":status" => "A");
        }

        return Usuarios::model()->count($criteria);
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 21/04/2014 
     * descrição: 
     *      renderiza o o formulario "main/usuarios/index.php"
     */

    public function actionIndex() {
        $this->render('index');
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 01/05/2017
     * data última atualização: 01/05/2017 
     * descrição: 
     *      Direciona para o _Form se não receber parametro POST.
     *      Se receber um POST verifica e adiciona um novo usuário a base de dados.
     */

    public function actionCreate() {

        $model = new Usuarios();
        $retorno = array();

        if ($_POST) {



            $retorno['tipo'] = "SUCESSO";
            $retorno['msg'] = "ok";

            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();

            try {

                //variável referente ao usuário
                $usuario = trim($_POST['usuario']);
                if (empty($usuario)) {
                    throw new Exception("<strong>Login</strong> não pode ser vazio.");
                }

                //restruturar o nome no usuário
                $usuario = Util::spaceToPoint($usuario);
                $usuario = Util::replaceCaracterEspecial($usuario);

                //variável referente a senha
                $senha = trim($_POST['senha']);
                if (empty($senha)) {
                    throw new Exception("<strong>Senha</strong> não pode ser vazia.");
                }

                //variável referente a nome
                $nome = trim($_POST['nome']);
                if (empty($nome)) {
                    throw new Exception("<strong>Nome</strong> não pode ser vazio.");
                }
                $nome = Util::toUpperSpecial($nome);
                
                $model->nome = $nome;
                $model->usuario = $usuario;
                $model->senha = SHA1($senha);
                $model->datahoracriacao = date("Y-m-d H:i:s");
                $model->datahoraatualizacao = date("Y-m-d H:i:s");
                $model->status = 'A';
                
                if ($model->validate()) {
                    if ($this->verificarExistenciaUsuario($model->usuario, 0) > 0) {
                        throw new Exception("Usuário já cadastrado");
                    }
                    if (!$model->save()) {
                        throw new Exception("Falha ao tentar salvar");
                    }
                    $transaction->commit();
                } else {
                    throw new Exception('<strong>Nada foi feito</strong>, Falha ao validar formulário');
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                $retorno['tipo'] = "error";
                $retorno['msg'] = $ex->getMessage();
            }
            Yii::app()->end(json_encode($retorno));
        }
        $this->render('create', array('model' => $model,));
    }

    /*
     * autor: jlaurosouza
     * atualizado por: jlaurosouza
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Atualiza os Dados do Usuário
     */

    public function actionUpdate($id = "") {

        if (empty($id) && !is_numeric($id)) {
            $this->redirect(Yii::app()->createAbsoluteUrl('main/usuarios/index'));
        }

        $retorno = array();

        if (!$this->verificarUsuarioAtivo($id)) {
            $this->redirect(array("index"));
        }

        $model = $this->loadModel($id);

        if ($_POST) {
            $retorno['tipo'] = "SUCESSO";
            $retorno['msg'] = "ok";
            try {

                //variável referente a nome
                $nome = trim($_POST['nome']);
                if (empty($nome)) {
                    throw new Exception("<strong>Nome</strong> não pode ser vazio.");
                }
             
                $model->nome = Util::toUpperSpecial($nome);
                $model->datahoraatualizacao = date("Y-m-d H:i:s");

                if ($model->validate()) {
                    if (!$model->save()) {
                        throw new Exception("Falha ao tentar salvar");
                    }
                } else {
                    throw new Exception('<strong>Nada foi feito</strong>, Falha ao validar formulário');
                }
            } catch (Exception $ex) {
                $retorno['tipo'] = "error";
                $retorno['msg'] = $ex->getMessage();
            }
            Yii::app()->end(json_encode($retorno));
        }
        $this->render('update', array('model' => $model,));
    }
    
    /*
     * autor: Lauro Souza
     * atualizado por: 
     * data criação: 30/04/2017
     * data última atualização: 30/04/2017 
     * descrição: 
     *      Atualiza as Colunas (status = I), inválidando o acesso da conta.
     * Tabela: usuarios
     */

    public function actionInactivate($id = "") {

        if (empty($id) && !is_numeric($id)) {
            $this->redirect(Yii::app()->createAbsoluteUrl('main/usuarios/index'));
        }

        $model = Usuarios::model()->findByPk($id);

        $retorno = array();

        $retorno['tipo'] = "SUCESSO";
        $retorno['msg'] = "ok";

        if (!$this->verificarUsuarioAtivo($id)) {
            $this->redirect(array("index"));
        }
        try {
            $model->status = "I";
            $model->datahoraatualizacao = date("Y-m-d H:i:s");

            if ($model->validate()) {
                if (!$model->save()) {
                    throw new Exception("Falha ao tentar salvar");
                }
            } else {
                throw new Exception('<strong>Nada foi feito</strong>, Falha ao validar formulário');
            }
        } catch (Exception $ex) {
            $retorno['tipo'] = "error";
            $retorno['msg'] = $ex->getMessage();
        }
        Yii::app()->end(json_encode($retorno));
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Carrega o formuário com os dados do usuário.
     */

    public function loadModel($id) {
        $model = Usuarios::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Valida o s parametros POST e atualiza a senha na base de dados.
     */

    public function actionRedefinirsenha() {

        $msg = array();
        $listaError = array();

        if ($_POST) {

            $senha = $_POST["senhaatual"];
            $nsenha = $_POST["novasenha"];
            $cnsenha = $_POST["cnovasenha"];

            if (empty($senha)) {
                $addError[] = "<strong>Senha atual</strong> deve ser preenchida";
            }
            if (empty($nsenha)) {
                $addError[] = "<strong>Nova Senha</strong> deve ser preenchida";
            }
            if (empty($cnsenha)) {
                $addError[] = "<strong>Confirme</strong> a nova senha";
            }

            if (!empty($addError)) {
                for ($i = 0; $i < count($addError); $i++) {
                    $listaError.= $addError[$i] . "<br>";
                }
            } else {

                if ($this->verificarSenhaAtual($senha) > 0) {
                    if ($nsenha == $cnsenha) {

                        $model = Usuarios::model()->findByPk(Yii::app()->user->id);
                        $model->senha = SHA1($nsenha);
                        $model->save();

                        $msg["msg"] = "Senha redefinida com sucesso";
                    } else {
                        $listaError = "Confirmação de senha incorreta";
                    }
                } else {
                    $listaError = "<strong>Senha</strong> atual incorreta";
                }
            }
        }

        $this->render("redefinirsenha", array("listaError" => $listaError, "msg" => $msg));
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Verifica se a senha informada esta correta.
     */

    private function verificarSenhaAtual($senha) {

        $criteria = new CDbCriteria;
        $criteria->condition = "senha=:senha";
        $criteria->params = array(":senha" => SHA1($senha));

        return Usuarios::model()->count($criteria);
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Verifica se o Usuario esta ativo.
     */

    private function verificarUsuarioAtivo($id) {

        $criteria = new CDbCriteria();
        $criteria->condition = "id=:id and status=:status";
        $criteria->params = array(":id" => $id, ":status" => "A");

        $total = Usuarios::model()->count($criteria);

        if ($total > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 30/04/2017 
     * descrição: 
     *      
     */

    public function actionGrid() {

        $condition = '';
        $params = array();

        $rows = isset($_POST['iDisplayLength']) ? intval($_POST['iDisplayLength']) : 25;
        $page = isset($_POST['iDisplayStart']) && !empty($_POST['iDisplayStart']) ? (intval($_POST['iDisplayStart']) / $rows) + 1 : 1;

        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria;
        $criteria->alias = "u";
        $criteria->select = "u.*";

        if (isset($_POST['sSearch_0']) && !empty($_POST['sSearch_0'])) {
            $condition .= 'u.nome LIKE :search AND u.status=:status';
            $params[":search"] = '%' . trim($_POST['sSearch_0']) . '%';
            $params[":status"] = "A";
        } else if (isset($_POST['sSearch_1']) && !empty($_POST['sSearch_1'])) {
            $condition .= 'u.usuario LIKE :search AND u.status=:status';
            $params[":search"] = '%' . trim($_POST['sSearch_1']) . '%';
            $params[":status"] = "A";
        } else {
            $condition .= 'u.status=:status';
            $params[":status"] = "A";
        }

        $criteria->condition = $condition;
        $criteria->params = $params;

        $result["iTotalRecords"] = Usuarios::model()->count($criteria);
        $result["iTotalDisplayRecords"] = Usuarios::model()->count($criteria);
        $result["iDisplayStart"] = $page;
        $result["iDisplayLength"] = $rows;

        $sort = isset($_POST['sSortDir_0']) ? trim($_POST['sSortDir_0']) : 'ASC';
        $order = isset($_POST['iSortCol_0']) ? trim($_POST['iSortCol_0']) : 'id';

        switch ($order) {
            case 0:
                // NOME.
                $order = 'u.nome';
                break;

            case 1:
                // USUÁRIO.
                $order = 'u.usuario';
                break;
            default:
                $order = 'u.nome';
                break;
        }

        $criteria->order = $order ;//. ' ' . $sort;
        $criteria->limit = $rows;
        $criteria->offset = $offset;

        $model = Usuarios::model()->findAll($criteria);
        $grid = array();
        $i = 0;

        foreach ($model as $m) {
            
            $btUrl = '<a style="display:floatleft; margin-right:12px; padding:5px 10px;" class="btn btn-primary btnacao" href="' . Yii::app()->createAbsoluteUrl('main/usuarios/update/id/' . $m->id) . '"><i class="fa fa-edit"></i> Editar</a><a style="display:floatleft; padding:5px 10px;" class="btn btn-default btnacao" onclick="inativar(' . $m->id . ')" href="javascript:void(0)"><i class="fa fa-ban txt-color-red"></i> Inativar</a>';
          
            $grid[0] = $m->nome;
            $grid[1] = $m->usuario;
            $grid[2] = $btUrl;

            $result["aaData"][$i] = $grid;
            $i++;
        }

        echo json_encode($result);
    }    
}