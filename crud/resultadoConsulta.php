<p>Itens Encontrados:</p>
<table class="consulta">

	<?php if (isset($vetCli)) { ?>

		<tr>
			<th>Código</th>
			<th>Nome</th>
			<th>Telefone</th>
			<th>Email</th>
			<th>Categoria</th>
			<th>Operação</th>
		</tr>
		<?php
			foreach($vetCli as $item){
				echo "<tr>".
					"<td>". $item->getId() ."</td>".
					"<td> <a href='ControllerCliente.php?acao=editar&id=" . $item->getId() . "'>". $item->getNome() ."</a></td>".
					"<td>". $item->getEmail() ."</td>".
					"<td>". $item->getTelefone() ."</td>".
					"<td>". $item->getCategoria()->getNome() ."</td>".
					"<td><a href=\"javascript:confirmarExclusao('". $item->getNome() . "', " . $item->getId() . ")\">Excluir</a></td>".
					"</tr>";
			}
		?>
	
	<?php } elseif (isset($vetCategoria)) { ?>

		<tr>
			<th>Código</th>
			<th>Nome</th>
			<th>Operação</th>
		</tr>
		<?php
		foreach($vetCategoria as $item){
			echo "<tr>".
				"<td>". $item->getId() ."</td>".
				"<td> <a href='ControllerCategoria.php?acao-categoria=editar&id=" . $item->getId() . "'>". $item->getNome() ."</a></td>".
				"<td><a href=\"javascript:confirmarExclusaoCategoria('". $item->getNome() . "', " . $item->getId() . ")\">Excluir</a></td>".
				"</tr>";
		}
		?>

	<?php } ?>

</table>