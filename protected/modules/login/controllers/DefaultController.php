<?php

class DefaultController extends Controller {

    public $layout = '//layouts/main-login';

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2017
     * data última atualização: 23/12/2017 
     * descrição: 
     *      renderiza o o formulario "login/default/index.php".
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
     *      Valida o usuario que esta acessando o sistema.
     */

    public function actionLogar() {
        
        $model = new LoginForm();
        
        $usuario = trim($_POST['usuario']);
        $senha = $_POST['senha'];
        $lembrar = $_POST['lembrar'];
        
        if ($model->login($usuario, $senha, $lembrar)) {
            Yii::app()->end("1");
        } else {
            Yii::app()->end("0");
        }
    }
    
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array("index"));
    }

}
