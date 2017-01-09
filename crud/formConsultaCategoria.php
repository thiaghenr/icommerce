<h2>Consultar Categorias</h2>
<p/>
<form action="ControllerCategoria.php" method="POST">
	<h4>Informe um critérios de busca</h4>

	<div class="input-box">
		<label for="nome-c">Nome</label>
		<input type="text" name="nome" id="nome-c"/>
	</div>

	<p/>
	<input type="submit" value="Consultar">
	<input type="reset" value="Limpar">
	<input type="hidden" name="acao-categoria" value="consultar">
</form>
