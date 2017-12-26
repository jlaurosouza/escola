<?php

class CursosController extends Controller {

    public $retorno = array();

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
     *     
     */

    public function verificarCursoAtivo($id) {

        if (!is_numeric($id)) {
            return false;
        }

        $criteria = new CDbCriteria();

        $criteria->condition = "id=:id and status=:status";
        $criteria->params = array(":id" => $id, ":status" => "A");

        $total = Cursos::model()->count($criteria);

        if ($total == 0) {
            return false;
        } else {
            return true;
        }
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      renderiza o o formulario "main/cursos/index.php"
     */

    public function actionIndex() {
        $this->render('index');
    }

    /*
     * autor: jlaurosouza
     * atualizado por: jlaurosouza
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Direciona para o _Form se não receber parametro POST.
     *      Se receber um POST verifica e adiciona um novo curso a base de dados.
     */

    public function actionCreate() {

        $model = new Cursos();

        if ($_POST) {

            $this->retorno['tipo'] = "SUCESSO";
            $this->retorno['msg'] = "ok";

            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();

            try {

                //Variável referente a descriçao
                $descricao = trim($_POST['descricao']);
                if (empty($descricao)) {
                    throw new Exception("<strong>Descricão</strong> não pode ser vazio.");
                }

                //Variável referente ao Valor
                $valor = $_POST['valor'];
                if (empty($valor)) {
                    throw new Exception("<strong>Valor</strong> não pode ser vazio.");
                }

                $model->descricao = Util::toUpperSpecial($descricao);
                $model->valor = Util::moedaBd($valor);
                $model->idoperador = Yii::app()->user->id;
                $model->datahoracriacao = date("Y-m-d H:i:s");
                $model->datahoraalteracao = date("Y-m-d H:i:s");
               
                if ($model->validate()) {

                    if ($this->verificarExistenciaCurso($model->descricao, 0)) {
                        throw new Exception("Curso já cadastrado");
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
                $this->retorno['tipo'] = "error";
                $this->retorno['msg'] = $ex->getMessage();
            }
            Yii::app()->end(json_encode($this->retorno));
        }
        $this->render('create', array('model' => $model,));
    }

    /*
     * autor: jlaurosouza
     * atualizado por: jlaurosouza
     * data criação: 17/04/2017
     * data última atualização: 17/04/2017 
     * descrição: Carrga as informações do curso selecionada.
     *            Se POST atualiza as informações do curso.
     *      
     */

    public function actionUpdate($id = "") {

        if (empty($id) && !is_numeric($id)) {
            $this->redirect(Yii::app()->createAbsoluteUrl('main/cursos/index'));
        }

        if ($this->verificarCursoAtivo($id) == 0) {
            $this->redirect(Yii::app()->createAbsoluteUrl('main/cursos/index'));
        }

        $model = $this->loadModel($id);

        if ($_POST) {

            $this->retorno['tipo'] = "SUCESSO";
            $this->retorno['msg'] = "ok";
            try {
                 //Variável referente a descriçao
                $descricao = trim($_POST['descricao']);
                if (empty($descricao)) {
                    throw new Exception("<strong>Descricão</strong> não pode ser vazio.");
                }

                
                //Variável referente ao Valor
                $valor = $_POST['valor'];
                if (empty($valor)) {
                    throw new Exception("<strong>Valor</strong> não pode ser vazio.");
                }
                
                $model->descricao = Util::toUpperSpecial($descricao);
                $model->valor = Util::moedaBd($valor);
                $model->idoperador = Yii::app()->user->id;
                $model->datahoraalteracao = date("Y-m-d H:i:s");
                              
                
                if ($model->validate()) {
                   
                    if (!$model->save()) {
                        throw new Exception('Desculpe-nos... Ocorreu algo inesperado. Não conseguimos atualizar as informações do curso.');
                    }
                    
                } else {
                    throw new Exception('<strong>Nada foi feito</strong>, Falha ao validar formulário');
                }
            } catch (Exception $ex) {
                $this->retorno['tipo'] = "error";
                $this->retorno['msg'] = $ex->getMessage();
            }
            Yii::app()->end(json_encode($this->retorno));
        }
        $this->render('update', array('model' => $model));
    }

    /*
     * autor: jlaurosouza
     * atualizado por: jlaurosouza
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Verifica se o cliente existe, se esta ativo e não deletado na base de dados.
     */

    public function verificarExistenciaCurso($desc, $codigo) {

        $criteria = new CDbCriteria();

        if ($codigo == 0) {
            $criteria->condition = "descricao=:descricao and status=:status";
            $criteria->params = array(":descricao" => $desc, ":status" => "A");
        } else {
            $criteria->condition = "descricao=:descricao and id<>:id and status=:status";
            $criteria->params = array(":descricao" => desc, ":id" => $codigo, ":status" => "A");
        }
        return Cursos::model()->count($criteria);
        ;
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Carrega o formuário com os dados do cliente.
     *      Verifica se os Dados são Validos, $id = id do curso no formulário.
     *      
     */

    public function loadModel($id) {

        $criteria = new CDbCriteria();
        $criteria->condition = "id=:id and status=:status";
        $criteria->params = array(":id" => $id, ":status" => "A");

        $model = Cursos::model()->find($criteria);
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
     *      Atualiza as Colunas (status = I), inativando o curso.
     */

    public function actionInactivate($id = "") {

        if (empty($id) && !is_numeric($id)) {
            $this->redirect(Yii::app()->createAbsoluteUrl('main/cursos/index'));
        }

        $model = Cursos::model()->findByPk($id);

        $url = Yii::app()->createAbsoluteUrl('main/cursos/index');

        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {

            $model->status = "I";
            $model->idoperador = Yii::app()->user->id;
            $model->datahoraalteracao = date("Y-m-d H:i:s");

            if ($model->validate()) {

                if (!$model->save()) {
                    throw new Exception("Falha ao tentar salvar");
                }
                $transaction->commit();
                $this->redirect($url . '/acao/inactivate');
            } else {
                throw new Exception('<strong>Nada foi feito</strong>, Falha ao validar formulário');
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            $this->redirect($url);
        }
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: Carrega e administra o Grid da index.
     *      
     */

    public function actionGrid() {

        $condition = '';
        $params = array();

        $rows = isset($_POST['iDisplayLength']) ? intval($_POST['iDisplayLength']) : 25;
        $page = isset($_POST['iDisplayStart']) && !empty($_POST['iDisplayStart']) ? (intval($_POST['iDisplayStart']) / $rows) + 1 : 1;

        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria;
        $criteria->alias = "e";
        $criteria->select = "e.*";

        if (isset($_POST['sSearch_0']) && !empty($_POST['sSearch_0'])) {
            $condition .= "e.descricao LIKE :search AND e.status=:status";
            $params[":search"] = '%' . trim($_POST['sSearch_0']) . '%';
            $params[":status"] = "A";
        } else if (isset($_POST['sSearch_1']) && !empty($_POST['sSearch_1'])) {
            $condition .= "e.valor LIKE :search AND e.status=:status";
            $params[":search"] = '%' . trim($_POST['sSearch_1']) . '%';
            $params[":status"] = "A";
        } else {
            $condition .= "e.status=:status";
            $params[":status"] = "A";
        }


        $criteria->condition = $condition;
        $criteria->params = $params;

        $result["iTotalRecords"] = Cursos::model()->count($criteria);
        $result["iTotalDisplayRecords"] = Cursos::model()->count($criteria);
        $result["iDisplayStart"] = $page;
        $result["iDisplayLength"] = $rows;

        $sort = isset($_POST['sSortDir_0']) ? trim($_POST['sSortDir_0']) : 'ASC';
        $order = isset($_POST['iSortCol_0']) ? trim($_POST['iSortCol_0']) : 'id';

        switch ($order) {
            case 0:
                // DESCRICÃO.
                $order = 'e.descricao';
                break;

            case 1:
                // VALOR.
                $order = 'e.valor';
                break;
            default:
                // acoes
                $order = 'e.id';
                break;
        }

        $criteria->order = $order . ' ' . $sort;
        $criteria->limit = $rows;
        $criteria->offset = $offset;

        $model = Cursos::model()->findAll($criteria);
        $grid = array();
        $i = 0;

        foreach ($model as $m) {

            $bntUrl = '<a style="display:floatleft; margin-right:12px; padding:5px 10px;" class="btn btn-primary btnacao" href="' . Yii::app()->createAbsoluteUrl('main/cursos/update/id/' . $m->id) . '"><i class="fa fa-edit"></i> Editar</a><a style="display:floatleft; padding:5px 10px;" class="btn btn-default btnacao" onclick="inativar(' . $m->id . ')" href="javascript:void(0)"><i class="fa fa-ban txt-color-red"></i> Inativar</a>';

            $grid[0] = $m->descricao;
            $grid[1] = Util::moedaBd($m->valor);           
            $grid[2] = $bntUrl;

            $result["aaData"][$i] = $grid;
            $i++;
        }

        echo json_encode($result);
    }

}