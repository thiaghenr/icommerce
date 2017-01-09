<?
    require_once("config.php");
    conexao();
    $cod = $_POST['cod'];
    $nom = $_POST['nom'];
  //  $sql = "SELECT controle,nome,endereco,telefonecom FROM clientes limit 0,200";
    $sql = "SELECT * FROM clientes WHERE controle LIKE '%$cod%' AND nome LIKE '%$nom%' AND ativo = 'S' GROUP BY nome asc";

    $rs = mysql_query($sql) or die (mysql_error());
	$num_cli = mysql_num_rows($rs);
    $str_dados="[";
    while($linha=mysql_fetch_array($rs)){
        $str_dados.="['".$linha['controle']."',";
        $str_dados.="'".$linha['nome']."',";
        $str_dados.="'".$linha['endereco']."',";
        $str_dados.="'".$linha['telefonecom']."'],";
    }
    $str_dados = substr($str_dados,0,strlen($str_dados)-1);
    $str_dados.= "]";

?>

<html>
<div align="center" class="Estilo1">
<table width="49%" border="0">
  <tr>
    <td width="15%" bgcolor="#D4D0C8">Nombre:</td>
    <td width="85%">
	<form name="nome" method="POST" action="result_clic.php">
	<input type="text" size="40" name="nom" value="<?=$_SESSION['nomeCli']?>"></td>
  </tr></form>
</table>
  <table width="100%" border="0">
    <tr>
      <td bgcolor="#DCE4F4"><div align="center">
          <p><strong>CLIENTES</strong></p>
      </div></td>
    </tr>
  </table>
</div>
<p>
<head>
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #f2f1e2;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}


</style>

<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='';
 }
 else if(lugar=='Nueva'){
  window.location.href='cotizacion.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>

	<title>Clientes - <? echo $title; ?></title>
	<style>body {font: 12px Tahoma}</style>

	<!-- ActiveWidgets stylesheet and scripts -->
	<link href="runtime/styles/aqua/aw.css" rel="stylesheet" type="text/css" ></link>
	<script src="runtime/lib/aw.js"></script>

	<!-- grid format -->
	<style>
		#myGrid {height: 450px; width: 100%;}
		#myGrid .aw-row-selector {text-align: center}

		#myGrid .aw-column-0 {width:  80px;}
		#myGrid .aw-column-1 {width: 200px;}
		#myGrid .aw-column-2 {width: 300px;}
		#myGrid .aw-column-3 {width: 100px;}

		#myGrid .aw-grid-cell {border-right: 1px solid threedlightshadow;}
		#myGrid .aw-grid-row {border-bottom: 1px solid threedlightshadow;}

		/* box model fix for strict doctypes, safari */
		.aw-strict #myGrid .aw-grid-cell {padding-right: 3px;}
		.aw-strict #myGrid .aw-grid-row {padding-bottom: 3px;}

	.Estilo1 {font-weight: bold}
    </style>

	<!-- grid data -->
	<script>
         var myData = <? echo $str_dados ?>;
		var myColumns = [
			"Codigo", "Nome", "Endereço", "Telefone Com."
		];

        function setaFoco(){
            document.getElementById('myGrid').focus();
        }
	</script>
</head>
<body onLoad="setaFoco()">
<div align="center">
<script>

	//	create ActiveWidgets Grid javascript object
	var obj = new AW.UI.Grid;
	obj.setId("myGrid");

	//	define data formats
	var str = new AW.Formats.String;
	var num = new AW.Formats.Number;

   	obj.setCellFormat([str, str, str, str]);

	//	provide cells and headers text
	obj.setCellText(myData);
	obj.setHeaderText(myColumns);

	//	set number of rows/columns
	obj.setRowCount(<? echo "$num_cli" ?>);
	obj.setColumnCount(4);

	//	enable row selectors
	obj.setSelectorVisible(true);
	obj.setSelectorText(function(i){return this.getRowPosition(i)+1});

	//	set headers width/height
   //	obj.setSelectorWidth(28);
//	obj.setHeaderHeight(20);

	//	set row selection
	obj.setSelectionMode("single-row");

	//	set click action handler
  /*	obj.onCellClicked = function(event, col, row){
		window.status = this.getCellText(col, row);
	};
*/
	obj.onKeyEnter = function(event){
		var row = obj.getCurrentRow();
        url = "cotizacion.php?acao=add&";
		var query = "controleCli=" + this.getCellText(0, row) + "&cli=" + this.getCellText(1, row) ;
		url+=query;
        window.location = url;

    }
document.write(obj);
	</script>

</div>
<p><font face="Arial">
  <input name="button" type="button" onClick="window.close()" value="Abandonar" />
</font> <input type="button" value="Volver" name="LINK12" onClick="navegacao('Nueva')" /></p>
</body>
</html>