var Util = {
    apenasLetras: function(v) {
        if (v >= 0) {
            return "";
        } else {
            return v;
        }
    },
    mascaraValor: function(v) {
        v = v.replace(/\D/g, "");//Remove tudo o que não é dígito
        v = v.replace(/(\d)(\d{8})$/, "$1.$2");//coloca o ponto dos milhões
        v = v.replace(/(\d)(\d{5})$/, "$1.$2");//coloca o ponto dos milhares
        v = v.replace(/(\d)(\d{2})$/, "$1,$2");//coloca a virgula antes dos 2 últimos dígitos
        return v;
    },
    mascaraTelefone: function(v) {
        if ((v.length) > 16) {
            v = v.substring(0, (v.length - 1));
        }
        v = v.replace(/\D/g, "");    //Remove tudo o que não é dígito

        if ((v.length) <= 10) {
            v = v.replace(/^(\d\d)(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
            v = v.replace(/(\d{4})(\d)/, "$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
        } else {
            v = v.replace(/^(\d\d)(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
            v = v.replace(/(\d)(\d{2})/, "$1 $2"); //Coloca ponto referênte ao nono dígitos
            v = v.replace(/(\d{4})(\d)/, "$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
        }
        return v;
    },
    limparCaracteres: function(v) {
        v = v.replace(/\D/g, "");    //Remove tudo o que não é dígito
        return v;
    },
    mascaraISBN: function(v) {
        v = v.replace(/\D/g, "");    //Remove tudo o que não é dígito

        if ((v.length) == 13) {
            v = v.replace(/(\d{3})(\d)/, "$1 $2");    //Coloca hífen entre o terceiro e o quarto dígitos
            v = v.replace(/(\d{2})(\d{2})/, "$1 $2");    //Coloca hífen entre o sexto e o sétimo dígitos
            v = v.replace(/(\d{3})(\d{3})/, "$1 $2");    //Coloca hífen entre o nono e o décimo dígitos
            v = v.replace(/(\d{4})(\d{1})/, "$1-$2");    //Coloca hífen entre o terceiro e o quarto dígitos
        } else if ((v.length) > 13) {
            v = v.substring(0, 13);
        }
        return v;
    },
    
    mascaraTombamento: function(v) {
        v = v.replace(/\D/g, "");    //Remove tudo o que não é dígito
        v = v.replace(/(\d{4})(\d{4})/, "$1/$2");    //Coloca hífen entre o terceiro e o quarto dígitos
        return v;
    },
    validarData: function(v) {
        var data = v;
        var dia = data.substr(0, 2);
        var barra1 = data.substr(2, 1);
        var mes = data.substr(3, 2);
        var barra2 = data.substr(5, 1);
        var ano = data.substr(6, 4);
        if (data.length != 10 || barra1 != "/" || barra2 != "/" || isNaN(dia) || isNaN(mes) || isNaN(ano) || dia > 31 || mes > 12) {
            return false;
        }
        if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31) {
            return false;
        }
        if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0))) {
            return false;
        }
        if (ano < 1900) {
            return false;
        }
        return true;
    },
    numeroParaMoeda: function(n, c, d, t) {
        c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    },
    ajustarInput: function(str) {
        var adicionar = 6 - str.length;
        for (var i = 0; i < adicionar; i++)
            str = '0' + str;
        return str.slice(0, 5) + str.slice(-1);
    },
    autorReferenciaSobrenome: function(str) {
        var sobrenome = "";
        for (var i = 0; i < str.length; i++) {
            var c = str.charAt(i);
            if (c == " ") {
                sobrenome = c;
            } else {
                sobrenome = sobrenome + c;
            }
        }
        return sobrenome;
    },
    getQtdNomes: function(str) {
        var qtd = 0;
        for (var i = 0; i < str.length; i++) {
            var c = str.charAt(i);
            if (c == " ") {
                qtd = qtd + 1;
            }
        }
        return qtd;
    }

};