<?php

class DefaultController extends Controller {

    public $retorno = array();

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Verifica se o usuário esta Logado, se não estiver rendiraciona o formulario "login/default/index.php"
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
     *      renderiza o o formulario "main/default/index.php"
     */

    public function actionIndex() {
        $this->render('index');
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Carrega as cidades de acordo com o estado selecionado.
     */

    public function actionCarregarCidades() {

        $dados = Cidade::model()->findAll('idestado=:idestado', array(':idestado' => (int) $_GET["codigoEstado"]));
        $data = CHtml::listData($dados, 'id', 'nome');

        $arrayCidades = array();
        $i = 0;
        foreach ($data as $key => $value) {
            $arrayCidades[$i]['id'] = $key;
            $arrayCidades[$i]['cidade'] = CHtml::encode($value);
            $i++;
        }

        Yii::app()->end(json_encode($arrayCidades));
    }

    /*
     * 	Função de busca de Endereço pelo CEP
     * 	-	Desenvolvido Felipe Olivaes para ajaxbox.com.br
     * 	-	Utilizando WebService de CEP da republicavirtual.com.br     
     * atualizado por: jlaurosouza
     * data última atualização: 26/01/2016
     * 
     * descrição: 
     *           Atualizado e adaptado por jlaurosouza
     * 
     * 
     */

    public function actionBuscarcep() {

        $cep = $_POST['cep'];
        
        $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep=' . urlencode($cep) . '&formato=query_string');
        
        if (!$resultado) {
            $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";

            parse_str($resultado, $this->retorno);

            if ($this->retorno['resultado_txt'] == "erro ao buscar cep") {
                $this->retorno['resultado_txt'] = "Serviço indisponível, Falha com a Rede. (Tente novamente)";
            }
        } else {

            parse_str($resultado, $this->retorno);
            
            $this->retorno['resultado_txt'] = Util::convertToUTF8($this->retorno['resultado_txt']);

            if ($this->retorno['resultado_txt'] == "sucesso - cep não encontrado") {
                $this->retorno['resultado_txt'] = "CEP não encontrado";
            } else {

                //Saber o Estado
                $criteria = new CDbCriteria();
                $criteria->condition = "uf=:uf";
                $criteria->params = array(":uf" => $this->retorno['uf']);

                $estado = Estado::model()->find($criteria);

                $this->retorno['iduf'] = $estado->id;
                $this->retorno['uf'] = $estado->nome;
                
                //fim
                //Saber a Cidade
               // die($this->retorno['cidade']);
                //$this->retorno['cidade'] = Util::convertToUTF8($this->retorno['cidade']);
                
                $cidade = $this->retorno['cidade'];
                
                $criteria->condition = "idestado=:idestado AND nome=:nome";
                $criteria->params = array(":idestado" => $this->retorno['iduf'], ":nome" => $cidade);
                
                $this->retorno['idcidade'] = Cidade::model()->find($criteria)->id;
                
                //fim
//                $this->retorno['bairro'] = Util::replaceCaracterEspecial(mb_convert_encoding($this->retorno['bairro'], "UTF-8"));
//                $this->retorno['tipo_logradouro'] = Util::replaceCaracterEspecial(mb_convert_encoding($this->retorno['tipo_logradouro'], "UTF-8"));
//                $this->retorno['logradouro'] = Util::replaceCaracterEspecial(mb_convert_encoding($this->retorno['logradouro'], "UTF-8"));

                $this->retorno['bairro'] = Util::convertToUTF8($this->retorno['bairro']);
                $this->retorno['tipo_logradouro'] = Util::convertToUTF8($this->retorno['tipo_logradouro']);
                $this->retorno['logradouro'] = Util::convertToUTF8($this->retorno['logradouro']);
            }
        }

        Yii::app()->end(json_encode($this->retorno));
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Retorna a Lista dos estados de acordo com o país selecionado.
     */

    public function actionGetListaEstado() {

        $criteria = new CDbCriteria();
        $criteria->condition = "idpais=:idpais";
        $criteria->params = array(':idpais' => (int) $_GET["idpais"]);

        $dados = Estado::model()->findAll($criteria);

        $data = CHtml::listData($dados, 'id', 'nome');

        $arrayEstado = array();
        $i = 0;
        foreach ($data as $key => $value) {
            $arrayEstado[$i]['id'] = $key;
            $arrayEstado[$i]['nome'] = $value;
            $i++;
        }
        Yii::app()->end(json_encode($arrayEstado));
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Retorna a Lista das cidades de acordo com o estado selecionado.
     */

    public function actionGetListaCidade() {

        $criteria = new CDbCriteria();
        $criteria->condition = "idestado=:idestado";
        $criteria->params = array(':idestado' => (int) $_GET["idestado"]);

        $dados = Cidade::model()->findAll($criteria);

        $data = CHtml::listData($dados, 'id', 'nome');

        $arrayCidade = array();
        $i = 0;
        foreach ($data as $key => $value) {
            $arrayCidade[$i]['id'] = $key;
            $arrayCidade[$i]['nome'] = $value;
            $i++;
        }
        Yii::app()->end(json_encode($arrayCidade));
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      Retorna a Lista das operadoras.
     */

    public function actionGetListaOperadoras() {

        $criteria = new CDbCriteria();
        $criteria->condition = "status=:status";
        $criteria->params = array(':status' => 'A');

        $dados = Operadoras::model()->findAll($criteria);

        $data = CHtml::listData($dados, 'id', 'descricao');

        $arrayOperadoras = array();
        $i = 0;
        foreach ($data as $key => $value) {
            $arrayOperadoras[$i]['id'] = $key;
            $arrayOperadoras[$i]['descricao'] = $value;
            $i++;
        }
        Yii::app()->end(json_encode($arrayOperadoras));
    }       
}

