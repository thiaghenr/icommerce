<h2>Consultar clientes</h2>
<p/>
<form action="ControllerCliente.php" method="POST">
	<h4>Informe um ou mais critérios de busca</h4>
	
	<div class="input-box">
		<label for="nome">Nome</label>
		<input type="text" name="nome" id="nome"/>
	</div>

	<div class="input-box">
		<label for="telefone">Telefone</label>
		<input type="text" name="telefone" id="telefone">
	</div>

	<p/>
	<input type="submit" value="Consultar">
	<input type="reset" value="Limpar">
	<input type="hidden" name="acao" value="consultar">
</form>		
