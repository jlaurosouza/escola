<?php

class DefaultController extends Controller {
    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 17/11/2015
     * data última atualização: 17/11/2015 
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
     * data criação: 17/11/2015
     * data última atualização: 17/11/2015 
     * descrição: 
     *      renderiza o o formulario "main/default/index.php"
     */

    public function actionIndex() {
        $this->render('index');
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 20/11/2015
     * data última atualização: 20/11/2015 
     * descrição: 
     *      Carrega as cidades de acordo com o estado selecionado.
     */

    public function actionCarregarCidades() {
        
        $dados = Cidade::model()->findAll('idestado=:estado', array(':estado' => (int) $_POST["codigoEstado"]));
        $data = CHtml::listData($dados, 'id', 'nome');

        $arrayCidades = array();
        $i = 0;
        foreach ($data as $value => $name) {
            $arrayCidades[$i]['id'] = $value;
            $arrayCidades[$i]['cidade'] = CHtml::encode($name);
            $i++;
        }

        Yii::app()->end(json_encode($arrayCidades));
    }

}
