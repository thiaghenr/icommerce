<html>
<head>
	<?php
		include_once 'head.html';
	?>
</head>
<body>
	<?php
		include_once 'mensagem.php';
	?>
	<div id="titulo">
		<?php
			include_once 'titulo.html';
		?>		
	</div>
	<div id="menu" >
		<?php
			include_once 'menu.html';
		?>
	</div>	
	<div id="conteudo" >
		<?php
			if(!isset($tipoRes)){
				$tipoRes = "";
			}
			
			if($tipoRes == "tabela"){
				//aqui mostrar o resultado da consulta
				include_once "resultadoConsulta.php";
			}else if($tipoRes == "mensagem"){
				//aqui mostrar a mensagem de nenhum registro encontrado no banco
				echo("Não foram encontrados registros que atendam ao critério de pesquisa.");
			}else{
				//aqui mostrar form de filtro de pesquisa
				echo "<div class='form-left'>";
				include_once "formConsultaCliente.php";
				echo "</div>";

				echo "<div class='form-right'>";
				include_once "formConsultaCategoria.php";
				echo "</div>";
			}
		?>
	</div>
	<div id="rodape">
		<?php
			include_once 'rodape.html';
		?>
	</div>
</body>
</html>
