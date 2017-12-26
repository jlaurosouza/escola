<?php

class AlunosController extends Controller {

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

    public function verificarAlunoAtivo($id) {

        if (!is_numeric($id)) {
            return false;
        }

        $criteria = new CDbCriteria();

        $criteria->condition = "id=:id and status=:status";
        $criteria->params = array(":id" => $id, ":status" => "A");

        $total = Alunos::model()->count($criteria);

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
     *      renderiza o o formulario "main/alunos/index.php"
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
     *      Se receber um POST verifica e adiciona um novo aluno a base de dados.
     */

    public function actionCreate() {

        $model = new Alunos();

        if ($_POST) {

            $this->retorno['tipo'] = "SUCESSO";
            $this->retorno['msg'] = "ok";

            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();

            try {

                //Variável referente a Razão social
                $nome = trim($_POST['nome']);
                if (empty($nome)) {
                    throw new Exception("<strong>Nome do Aluno</strong> não pode ser vazio.");
                }

                //Variável referente ao CPF
                $cpf = Util::removerMaskCPF($_POST['cpf']);
                if (empty($cpf)) {
                    throw new Exception("<strong>CPF</strong> não pode ser vazio.");
                }

                //Variável referente ao CEP
                $cep = $_POST['cep'];
                if (empty($cep)) {
                    throw new Exception("<strong>CEP</strong> não pode ser vazio.");
                }

                //Variável referente ao e-mail do estado
                $estado = trim($_POST['estado']);
                if (empty($estado)) {
                    throw new Exception("<strong>Estado</strong> não pode ser vazio.");
                }

                //Variável referente ao cidade
                $cidade = trim($_POST['cidade']);
                if (empty($cidade)) {
                    throw new Exception("<strong>Cidade</strong> não pode ser vazio.");
                }

                //Variável referente ao bairro
                $bairro = trim($_POST['bairro']);
                if (empty($bairro)) {
                    throw new Exception("<strong>Bairro</strong> não pode ser vazio.");
                }

                //Variável referente ao rua
                $rua = trim($_POST['rua']);
                if (empty($rua)) {
                    throw new Exception("<strong>Logradouro</strong> não pode ser vazio.");
                }

                //Variável referente ao número
                $numero = trim($_POST['numero']);
                if (empty($numero)) {
                    throw new Exception("<strong>Número</strong> não pode ser vazio.");
                }

                //Variável referente ao e-mail.
                $email = trim($_POST['email']);

                $model->nome = Util::toUpperSpecial($nome);
                $model->cpf = $cpf;
                $model->cep = trim($cep);
                $model->estado = $estado;
                $model->cidade = $cidade;
                $model->bairro = Util::toUpperSpecial(trim($bairro));
                $model->rua = Util::toUpperSpecial(trim($rua));
                $model->numero = trim($numero);
                $model->complemento = Util::toUpperSpecial(trim($_POST['complemento']));
                $model->idoperador = Yii::app()->user->id;
                $model->datahoracriacao = date("Y-m-d H:i:s");
                $model->datahoraalteracao = date("Y-m-d H:i:s");
                $model->email = $email;

                if ($model->validate()) {

                    if ($this->verificarExistenciaAluno($model->cpf, 0)) {
                        throw new Exception("Aluno já cadastrado");
                    }
                    if (!$model->save()) {
                        throw new Exception("Falha ao tentar salvar");
                    }
                    //Cadastrando telefones
                    if (!empty($_POST['fones'])) {
                        if (!Util::inserirTelefone($model->id, $_POST['fones'], $_POST['operadoras'])) {
                            throw new Exception("<strong>Nada foi feito</strong>, Falha ao tentar cadastra telefones");
                        }
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
     * descrição: Carrga as informações do aluno selecionada.
     *            Se POST atualiza as informações do aluno.
     *      
     */

    public function actionUpdate($id = "") {

        if (empty($id) && !is_numeric($id)) {
            $this->redirect(Yii::app()->createAbsoluteUrl('main/alunos/index'));
        }

        if ($this->verificarAlunoAtivo($id) == 0) {
            $this->redirect(Yii::app()->createAbsoluteUrl('main/alunos/index'));
        }

        $model = $this->loadModel($id);

        if ($_POST) {

            $this->retorno['tipo'] = "SUCESSO";
            $this->retorno['msg'] = "ok";
            try {
                //Variável referente a Razão social
                $nome = trim($_POST['nome']);
                if (empty($nome)) {
                    throw new Exception("<strong>Nome do Aluno</strong> não pode ser vazio.");
                }

                //Variável referente ao CPF
                $cpf = Util::removerMaskCPF($_POST['cpf']);
                if (empty($cpf)) {
                    throw new Exception("<strong>CPF</strong> não pode ser vazio.");
                }

                //Variável referente ao CEP
                $cep = $_POST['cep'];
                if (empty($cep)) {
                    throw new Exception("<strong>CEP</strong> não pode ser vazio.");
                }

                //Variável referente ao e-mail do estado
                $estado = trim($_POST['estado']);
                if (empty($estado)) {
                    throw new Exception("<strong>Estado</strong> não pode ser vazio.");
                }

                //Variável referente ao cidade
                $cidade = trim($_POST['cidade']);
                if (empty($cidade)) {
                    throw new Exception("<strong>Cidade</strong> não pode ser vazio.");
                }

                //Variável referente ao bairro
                $bairro = trim($_POST['bairro']);
                if (empty($bairro)) {
                    throw new Exception("<strong>Bairro</strong> não pode ser vazio.");
                }

                //Variável referente ao rua
                $rua = trim($_POST['rua']);
                if (empty($rua)) {
                    throw new Exception("<strong>Logradouro</strong> não pode ser vazio.");
                }

                //Variável referente ao número
                $numero = trim($_POST['numero']);
                if (empty($numero)) {
                    throw new Exception("<strong>Número</strong> não pode ser vazio.");
                }

                //Variável referente ao e-mail.
                $email = trim($_POST['email']);

                $model->nome = Util::toUpperSpecial($nome);
                $model->cpf = $cpf;
                $model->cep = trim($cep);
                $model->estado = $estado;
                $model->cidade = $cidade;
                $model->bairro = Util::toUpperSpecial(trim($bairro));
                $model->rua = Util::toUpperSpecial(trim($rua));
                $model->numero = trim($numero);
                $model->complemento = Util::toUpperSpecial(trim($_POST['complemento']));
                $model->idoperador = Yii::app()->user->id;
                $model->datahoraalteracao = date("Y-m-d H:i:s");
                $model->email = $email;

                if ($model->validate()) {
                    if ($this->verificarExistenciaAluno($model->cpf, $id) > 0) {
                        throw new Exception("<strong>CNPJ</strong> cadastrado para outro cliente");
                    }
                    if (!$model->save()) {
                        throw new Exception('Desculpe-nos... Ocorreu algo inesperado. Não conseguimos atualizar as informações do aluno.');
                    }
                    //Cadastrando telefones
                    if (!empty($_POST['fones'])) {
                        if (!Util::inserirTelefone($id, $_POST['fones'], $_POST['operadoras'])) {
                            throw new Exception("<strong>Nada foi feito</strong>, Falha ao tentar cadastra telefones");
                        }
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

    public function verificarExistenciaAluno($cpf, $codigo) {

        $criteria = new CDbCriteria();

        if ($codigo == 0) {
            $criteria->condition = "cpf=:cpf and status=:status";
            $criteria->params = array(":cpf" => $cpf, ":status" => "A");
        } else {
            $criteria->condition = "cpf=:cpf and id<>:id and status=:status";
            $criteria->params = array(":cpf" => $cpf, ":id" => $codigo, ":status" => "A");
        }
        return Alunos::model()->count($criteria);
        ;
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Carrega o formuário com os dados do cliente.
     *      Verifica se os Dados são Validos, $id = id do aluno no formulário.
     *      
     */

    public function loadModel($id) {

        $criteria = new CDbCriteria();
        $criteria->condition = "id=:id and status=:status";
        $criteria->params = array(":id" => $id, ":status" => "A");

        $model = Alunos::model()->find($criteria);
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
     *      Atualiza as Colunas (status = I), inativando o aluno.
     */

    public function actionInactivate($id = "") {

        if (empty($id) && !is_numeric($id)) {
            $this->redirect(Yii::app()->createAbsoluteUrl('main/alunos/index'));
        }

        $model = Alunos::model()->findByPk($id);

        $url = Yii::app()->createAbsoluteUrl('main/alunos/index');

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
            $condition .= "e.nome LIKE :search AND e.status=:status";
            $params[":search"] = '%' . trim($_POST['sSearch_0']) . '%';
            $params[":status"] = "A";
        } else if (isset($_POST['sSearch_1']) && !empty($_POST['sSearch_1'])) {
            $condition .= "e.cpf LIKE :search AND e.status=:status";
            $params[":search"] = '%' . trim($_POST['sSearch_1']) . '%';
            $params[":status"] = "A";
        } else if (isset($_POST['sSearch_2']) && !empty($_POST['sSearch_2'])) {
            $criteria->join = ',cidade c';
            $condition .= "c.nome LIKE :search AND e.cidade=c.id AND e.status=:status";
            $params[":search"] = '%' . trim($_POST['sSearch_2']) . '%';
            $params[":status"] = "A";
        } else if (isset($_POST['sSearch_3']) && !empty($_POST['sSearch_3'])) {
            $condition .= "e.status=:search";
            $params[":search"] = trim($_POST['sSearch_3']);
        } else {
            $condition .= "e.status=:status";
            $params[":status"] = "A";
        }


        $criteria->condition = $condition;
        $criteria->params = $params;

        $result["iTotalRecords"] = Alunos::model()->count($criteria);
        $result["iTotalDisplayRecords"] = Alunos::model()->count($criteria);
        $result["iDisplayStart"] = $page;
        $result["iDisplayLength"] = $rows;

        $sort = isset($_POST['sSortDir_0']) ? trim($_POST['sSortDir_0']) : 'ASC';
        $order = isset($_POST['iSortCol_0']) ? trim($_POST['iSortCol_0']) : 'id';

        switch ($order) {
            case 0:
                // NOME.
                $order = 'e.nome';
                break;

            case 1:
                // CPF.
                $order = 'e.cpf';
                break;

            case 2:
                // CIDADE
                $order = 'e.cidade';
                break;
            case 3:
                // STATUS
                $order = 'e.status';
                break;
            default:
                // acoes
                $order = 'e.id';
                break;
        }

        $criteria->order = $order . ' ' . $sort;
        $criteria->limit = $rows;
        $criteria->offset = $offset;

        $model = Alunos::model()->findAll($criteria);
        $grid = array();
        $i = 0;

        foreach ($model as $m) {

            $bntUrl = '<a style="display:floatleft; margin-right:12px; padding:5px 10px;" class="btn btn-primary btnacao" href="' . Yii::app()->createAbsoluteUrl('main/alunos/update/id/' . $m->id) . '"><i class="fa fa-edit"></i> Editar</a><a style="display:floatleft; padding:5px 10px;" class="btn btn-default btnacao" onclick="inativar(' . $m->id . ')" href="javascript:void(0)"><i class="fa fa-ban txt-color-red"></i> Inativar</a>';

            if ($m->status == 'A') {
                $status = "ATIVO";
            } else {
                $status = "INATIVO";
            }

            $grid[0] = $m->nome;
            $grid[1] = Util::mask($m->cpf, "###.###.###-##");
            $grid[2] = $m->cidade0['nome'];
            $grid[3] = $status;
            $grid[4] = $bntUrl;

            $result["aaData"][$i] = $grid;
            $i++;
        }

        echo json_encode($result);
    }

}