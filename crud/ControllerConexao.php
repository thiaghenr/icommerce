<?php

class ControllerConexao{
	private $conn = null;
	private $dbType = "mysql";
	
	//parametros de conexao
	private $host = "localhost";
	private $user = "root";
	private $senha = "";
	private $db = "dbteste";
	
	public function pegarConexao(){
		try{
			// realiza a conex�o
			// usando o padr�o: new PDO("tipo_do_banco:host=ip_do_host;dbname=nome_da_base", "usu�rio", "senha" );
			$this->conn = new PDO($this->dbType . ":host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->senha);
			return $this->conn;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}
	}
}

?>


