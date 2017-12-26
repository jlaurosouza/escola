<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;

    public function authenticate() {
        //echo('aki');
        $record = Usuarios::model()->findByAttributes(array('usuario' => $this->username));                
        
        if ($record === null){
            $this->errorCode = self::ERROR_USERNAME_INVALID;            
        }else if ($record->senha !== SHA1($this->password)){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;            
        }else if ($record->status != "A"){
            $this->errorCode = self::ERROR_USERNAME_INVALID;            
        }else {            
            $this->_id = $record->id;
            $this->setState('id', $record->id);
            $this->setState('nome', $record->nome);
            $this->errorCode = self::ERROR_NONE;
        }                
        
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}
