<?php
require_once "ControllerConexao.php";

class DaoCategoria{
	private $conexao;
	
	function __construct(){
		$this->conectar();
	}
	
	private function conectar(){
		$controllerCon = new ControllerConexao();
		$this->conexao = $controllerCon->pegarConexao();
	}
	
	private function desconectar(){
		$this->conexao = null;
	}
	
	public function inserir($categoria){
		try{
			$stmt = $this->conexao->prepare("INSERT INTO tbcategoria (nome) VALUES (?)");
			$stmt->bindValue(1, $categoria->getNome());

			$resultado = $stmt->execute();

			$this->desconectar();

			return $resultado;

		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}

	public function consultar(){
		try{
			$vetCategorias = null;
			$stmt = $this->conexao->query("SELECT * FROM tbcategoria");

			foreach($stmt as $row){
				$categoria = new Categoria();
				$categoria->setId($row["id_categoria"]);
				$categoria->setNome($row["nome"]);
				$vetCategorias[] = $categoria;
			}

			$this->desconectar();

			return $vetCategorias;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}

	public function consultarComFiltro($categoria){
		try{
			$query = "SELECT * FROM tbcategoria where ";
			$criterios = 0;
			
			if($categoria->getNome() != ""){
				$query = $query . "nome = ?";
				$criterios++;
			}

			$vetCategorias = null;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			
			//sequencia de parametros para os ?
			$pos = 0;

			if($categoria->getNome() != ""){
				$pos++;
				$stmt->bindValue($pos, $categoria->getNome());
			}	

			$stmt->execute();			
			
			foreach($stmt as $row){
				$categoria = new Categoria();
				$categoria->setId($row["id_categoria"]);
				$categoria->setNome($row["nome"]);
				$vetCategorias[] = $categoria;
			}
			$this->desconectar();
			return $vetCategorias;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	
	public function excluir($id){
		try{
			$qtde = $this->conexao->exec("DELETE FROM tbcategoria WHERE id_categoria = " . $id);
			$this->desconectar();
			return $qtde;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}

	public function consultarPorId($id){
		try{
			$stmt = $this->conexao->query("SELECT * FROM tbcategoria WHERE id_categoria = " . $id);
			$categoria = null;
			foreach($stmt as $row){
				$categoria = new Categoria();
				$categoria->setId($row["id_categoria"]);
				$categoria->setNome($row["nome"]);
			}
			$this->desconectar();
			return $categoria;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}
	
	public function atualizar($categoria){
		try{
			$stmt = $this->conexao->prepare("UPDATE tbcategoria SET nome = ? WHERE id_categoria = ?");
			$stmt->bindValue(1, $categoria->getNome());
			$stmt->bindValue(2, $categoria->getId());

			$resultado = $stmt->execute();

			$this->desconectar();
			
			return $resultado;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}	
}
?>








