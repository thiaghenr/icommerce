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
			if ($tipo == 'cliente') {
				include_once 'formEditaCliente.php';
			} else if ($tipo == 'categoria') {
				include_once 'formEditaCategoria.php';
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
