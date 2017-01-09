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
		<div class="form-left">
			<?php include_once 'formCadastroCliente.php' ?>
		</div>

		<div class="form-right">
			<?php include_once 'formCadastroCategoria.php' ?>
		</div>
	</div>
	<div id="rodape">
		<?php
			include_once 'rodape.html';
		?>
	</div>
</body>
</html>
