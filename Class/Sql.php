<?php

//sql.php

class Sql extends PDO {     // A classe Sql extende a classe PDO, logo tudo o que a classe PDO faz a Sql tambem (ex: bind param, execute, prepare ...).

    private $conn;  // variavel referente à conexao.

    public function __construct() {    // método construtor do objeto (quando faço um new à classe Sql) pretendo que conecte automaticamente à Base dados.

       $this->conn = new PDO("mysql:host=localhost;dbname=dbphp", "root", "1pwdsql");  // $this->conn : coloco na variavel(atributo) conn a string de conexão.

    }

    private function setParams($statement, $parameters = array()) {   // metodo que recebe o statment e os dados(parameters) que é um array por padrao.

        foreach ($parameters as $key => $value) { 

            $this->setParam($statement, $key, $value);  //  chamo o metodo setParam abaixo.

        }

    }

    private function setParam($statement, $key, $value){   // metodo que recebe o statment, a chave e o valor. Nao preciso de passar todos os dados pois só estou a fazer um bind de parametro.

        $statement->bindParam($key, $value);

    }

    public function execQuery($rawQuery, $params = array()) {  // Método que recebe dois parametros (rawQuery, "query bruta" que vai ser tratada depois e parametros (os dados) que vao ser um array)

        $stmt = $this->conn->prepare($rawQuery);  // variavel $stmt que recebe o atributo conn e faco um prepare que recebe o rawQuery

        $this->setParams($stmt, $params);  // chamo o metodo setParams que sabe como faz o set de cada um dos parametros. Passo o statment($stmt) e os parameters ($params)

        $stmt->execute();  // execute tem o retorno dele mesmo, retorna o objeto.

        return $stmt;

    }

    public function select($rawQuery, $params = array()):array  // metodo para o select. Quando faco um select, pretendo obter uma linha ou mais. Passo a "query bruta (rawQuery" e os parametros como array
    {

        $stmt = $this->execQuery($rawQuery, $params);  // Para preparar a query, para aceitar os parametros, chamo o metodo query que já faz isso.

        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // o metodo fetch está dentro do stmt.

    }

}

?>