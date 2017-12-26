<?php

class Util {

    /*
     * autor: jlaurosouza
     * atualizado por: jlaurosouza
     * data criação: 23/12/2017
     * data última atualização: 23/12/2016 
     * descrição: 
     * 
     *      
     */

    public static function inserirTelefone($aluno, $fones, $operadoras) {
        
        Telefones::model()->deleteAll("idaluno='$aluno'");
        
        foreach ($fones as $key => $value) {
             
                        
            $modelfone = new Telefones();

            $modelfone->idaluno = $aluno;
            $modelfone->numero = $value;
            $modelfone->idoperadora = $operadoras[$key];

            if ($modelfone->validate()) {
                $modelfone->save();
            }else{
                die("não validou");
            }
        }
        return true;
    }
    
    public static function convertToUTF8($strNome) {

        $retorno = mb_convert_encoding($strNome, "UTF-8");

        return $retorno;
    }

    public static function spaceToPoint($nome) {

        $novoNome = "";

        $nome = strtolower($nome);
        $partes = explode(" ", $nome);
        foreach ($partes as $p) {
            if (!empty($p)) {
                $novoNome .= $p . ".";
            }
        }

        $novoNome = substr($novoNome, 0, (strlen($novoNome) - 1));
        return $novoNome;
    }

    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 16/12/2015
     * data última atualização: 16/12/2015 
     * descrição: 
     *      verifica se a data passada por parametro é uma daa válida.
     */

    public static function replaceCaracterEspecial($strNome) {

        $source = array('ç', 'Ç', 'á', 'à', 'â', 'ã', 'ä', 'Á', 'À', 'Â', 'Ã', 'Ä', 'é', 'è', 'ê', 'ë', 'É', 'È', 'Ê', 'Ë',
            'í', 'ì', 'î', 'ï', 'Í', 'Ì', 'Î', 'Ï', 'ó', 'ò', 'ô', 'õ', 'ö', 'Ó', 'Ò', 'Ô', 'Õ', 'Ö', 'ú', 'ù',
            'û', 'ü', 'Ú', 'Ù', 'Û', 'Ü', '~', '´', '`', '¨', '^');
        $replace = array('c', 'C', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E',
            'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O', 'u', 'u',
            'u', 'u', 'U', 'U', 'U', 'U', '', '', '', '', '');
        return str_replace($source, $replace, $strNome);
    }
    /*
     * autor: jlaurosouza
     * atualizado por: 
     * data criação: 23/12/2015
     * data última atualização: 23/12/2015 
     * descrição: 
     *      Converte a palavra com os caracteres especiais contidos.
     */

    public static function toUpperSpecial($strNome) {

        $newName = strtoupper(strtr($strNome, "áéíóúâêôãõàèìòùç", "ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
        return $newName;
    }

     public static function removerMaskCPF($cpf) {
        $string = str_replace(".", "", $cpf);
        $string = str_replace("-", "", $string);
        return $string;
    }
    
     public static function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
    
     public static function moedaBd($valor) {

        $source = array('R$ ', '.', ',');
        $replace = array('', '', '.');
        return str_replace($source, $replace, $valor);
    }

    public static function dbMoeda($valor, $comRS = true) {
        if ($comRS)
            return 'R$ ' . number_format($valor, 2, ',', '.');
        else
            return number_format($valor, 2, ',', '.');
    }
    
}

?>