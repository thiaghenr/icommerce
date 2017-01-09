<?php
	//Fun��o que retorna o limite de registro por consulta
	function limite($tela){
		switch($tela){
			case "1":
				$limite = 12;
			break;
			case "2":
				$limite = 9;
			break;
			case "3":
				$limite = 12;
			break;
		}
		return $limite;
	}
	//Funcao para geração de ordenacao
	function ordenacao($campo,$descricao,$desc,$order,$param,$pagina){
		$texto_ordenacao="";
		
		$texto_ordenacao="<a href={$_SERVER["PHP_SELF"]}?&acao=lista&pagina=$ant_pagina&order=$campo&pagina=$pagina";
		$total_param = count($param);	
		for($z=0;$z<$total_param;$z++){
			$texto_ordenacao .= "&param[$z]=$param[$z]";					
		}
	
		
		if($order=="$campo"){		
			if($desc==""){
				$texto_ordenacao.="&desc=DESC class=\"tabela_grid\">$descricao</a>&nbsp;<img src=\"./img/arrow_down.gif\" width=\"8\" height=\"10\">";
			} else {
				$texto_ordenacao.="&desc= class=\"tabela_grid\">$descricao</a>&nbsp;<img src=\"./img/arrow_up.gif\" width=\"8\" height=\"10\">";
			}			
		} else {
			$texto_ordenacao.="&desc= class=\"tabela_grid\">$descricao</a>&nbsp;<img src=\"./img/arrow.gif\" width=\"8\" height=\"10\">";		
		}
		$texto_ordenacao .=" ";
		return $texto_ordenacao;
	}
	
	
	//Funcaoo que monta a SQL de paginacao
	function paginacao($tela,$total,$sql,$pagina, &$inicio, &$limite){
		//Contagem de paginas da paginacao
		$limite = limite($tela);
		@$paginas = ceil($total/$limite);
		if(!isset($pagina)) { $pagina = 0; }
		$inicio = $pagina * $limite;
		//$sql_c = $sql." LIMIT $limite OFFSET $inicio";
		//return $sql_c;
	}
	
	//Funcao que monta a tabela de paginacao
	function tabela_paginacao($tela,$pagina,$total,$desc,$order,$param){
		//Total de amostragem de registros por pagina
		$limite = limite($tela);
		$paginas = @ceil($total/$limite);
		//********** PAGINACAO **********************////	
		
		if($total==0){
			  $tabela_paginacao.= "<table width=\"175\" border=\"0\" class=\"paginacao_tabela\" align=\"right\" cellpadding=\"0\" cellspacing=\"0\">
								  <tr height=\"18\" >
								
									<th scope=\"col\" width=\"95\" align=right colspan=5 class=\"paginacao_tabela\">($paginas de $paginas)</th>
								  </tr>
								</table>";
		} else {
		if($pagina<$paginas){
			$num_pagina = $pagina + 1;
			if($pagina==0){
				$ant_pagina = 0;
			} else {
				$ant_pagina = $pagina-1;				
			}
			if($pagina==$paginas-1){
				$prox_pagina = $paginas-1;
			} else {
				$prox_pagina = $pagina+1;
			}
			$total_param = count($param);

			$anterior="<a href=$PHP_SELF?&acao=lista&pagina=$ant_pagina&desc=$desc&order=$order";
			$proximo="<a href=$PHP_SELF?&acao=lista&pagina=$prox_pagina&desc=$desc&order=$order";
			
			for($z=0;$z<$total_param;$z++){
				$anterior .= "&param[$z]=$param[$z]";
				$proximo .= "&param[$z]=$param[$z]";			
			}
			$anterior .=" class=\"paginacao_tabela\">anterior</a>";
			$proximo .=" class=\"paginacao_tabela\">proximo</a>";
			$btn_anterior = "<img src=\"img/previous_off.gif\" width=\"6\" height=\"9\">";
			
			$btn_proximo = "<img src=\"img/next_off.gif\" width=\"6\" height=\"9\">";
		  }  
		  
				 
		  $tabela_paginacao.= "<table width=\"195\" border=\"0\" class=\"paginacao_tabela\" align=\"right\" cellpadding=\"0\" cellspacing=\"0\">
								  <tr height=\"18\" class=\"paginacao_tabela\">
									<th scope=\"col\" width=\"10\">$btn_anterior</th>
									<th scope=\"col\" width=\"50\">&nbsp;$anterior</th>
									<th scope=\"col\" width=\"75\" class=\"paginacao_tabela\">($num_pagina de $paginas)</th>
									<th scope=\"col\" width=\"50\">$proximo</th>
									<th scope=\"col\" width=\"10\">$btn_proximo</th>
								  </tr>
								</table>";
		 }
		  return $tabela_paginacao;
		
	}
//******************************************************************************************************************//
//*****************************************************************************************************************//	
	
	//STRING / HEX
	
	function strhex($string){
   		$hex="";
   		for ($i=0;$i<strlen($string);$i++){
       		$hex.=(strlen(dechex(ord($string[$i])))<2)? "0".dechex(ord($string[$i])): dechex(ord($string[$i]));
   		}
   		return $hex;
	}
	function hexstr($hex){
   		$string="";
   		for ($i=0;$i<strlen($hex)-1;$i+=2){
       		$string.=chr(hexdec($hex[$i].$hex[$i+1]));
   		}
   		return $string;
	}
	
	//Converte data de 2005-12-12 para 12/12/2005 e de 12/12/2005 para 2005-12-12
	//Opcao 1 para 2005-12-12 para 12/12/2005 
	//Opcao 2 para 12/12/2005 para 2005-12-12
	function converte_data($opcao,$data){
		switch($opcao){
			//FORMATO NORMAL
			case "1":
				$data = substr($data,8,2) . "/" . substr($data,5,2) . "/" . substr($data,0,4);	
				return $data;
			break;
			//FORMATO DO BANCO
			case "2":
				$data = substr($data,6,10).'-'.substr($data,3,2).'-'.substr($data,0,2);
				return $data;
			break;
		}
		
	}
	function converte_datat($opcao,$data){
		switch($opcao){
			//FORMATO NORMAL
			case "1":
				$data = substr($data,8,2) . "-" . substr($data,5,2) . "-" . substr($data,0,4);	
				return $data;
			break;
			//FORMATO DO BANCO
			case "2":
				$data = substr($data,6,10).'-'.substr($data,3,2).'-'.substr($data,0,2);
				return $data;
			break;
		}
		
	}
	
	function sexo($sexo){
		switch(strtolower($sexo)){
			case "m":
				$sexo = "Masculino";	
				return $sexo;
			break;
			
			case "f":
				$sexo = "Feminino";
				return $sexo;
			break;
		}
	}
	
	function sexoAnimal($sexo) {
		switch(strtolower($sexo)) {
			case "m";
				return "Macho";
			break;
			
			case "f";
				return "F&ecirc;mea";
			break;
		}
	}
	
	function status($status){
		$status = strtolower($status);
		switch($status){
			case "a":
				$status = "Ativo";	
				return $status;
			break;
			
			case "d":
				$status = "Desativado";
				return $status;
			break;
			
			case "i":
				$status = "Inativo";
				return $status;
			break;
		}
	}
	
	function tipo($tipo){
		$tipo = strtolower($tipo);
		switch($tipo){
			case "p":
				$tipo = "Permanente";
				return $tipo;
			break;
			
			case "t":
				$tipo = "Tempor&aacute;rio";
				return $tipo;
			break;
		}
	}
	
	function placaVeiculo($placa){
		$bol = false;
		if ( !is_numeric($placa[0]) ){
			for($i=0;$i<strlen($placa);$i++){
				if (is_numeric($placa[$i]) and $bol==false){
					$total .= '-'.$placa[$i];
					$bol = true;
				}
				else{
					$total .= $placa[$i];
				}
			}
		}
		else{
			for($i=0;$i<strlen($placa);$i++){
				if (!is_numeric($placa[$i]) and $bol==false){
					$total .= '-'.$placa[$i];
					$bol = true;
				}
				else{
					$total .= $placa[$i];
				}
			}
		}
	return $total;
	}
	
	function deficiente($status){
		switch($status){
			case "N" || "n":
				$status = "N&atilde;o";	
				return $status;
			break;
			
			case "S" || "s":
				$status = "Sim";
				return $status;
			break;
		}
	}
	
	function mascara($valor,$tipo){
		switch($tipo){
			case "rg":
				$aux = $valor;
				$valor = "";
				$valor .= substr($aux, 0,1).".";
				$valor .= substr($aux, 1,3).".";
				$valor .= substr($aux, 4,3)."-";
				$valor .= substr($aux, 7,1); 	
				return $valor;
			break;
			
			case "cpf":
				$aux = $valor;
				$valor = "";
				$valor .= substr($aux, 0,3).".";
				$valor .= substr($aux, 3,3).".";
				$valor .= substr($aux, 6,3)."-";
				$valor .= substr($aux, 9,2); 	
				return $valor;
			break;
			
			case "cnpj":
				$aux = $valor;
				$valor .= substr($aux, 0,2).".";
				$valor .= substr($aux, 2,3).".";
				$valor .= substr($aux, 5,3)."/";
				$valor .= substr($aux, 8,4)."-"; 	
				$valor .= substr($aux, 12,2);
				return $valor;
			break;
			
			case "cep":
				$aux = $valor;
				$valor = "";
				$valor .= substr($aux, 0,5)."-";
				$valor .= substr($aux, -3);
				return $valor;
			break;
		}
	}

	function removerCaracter($v) {
		return str_replace(" ","",str_replace("-","",str_replace("/","",str_replace(",","",str_replace(".","",$v))))); 
	}
	
	function ajustaValor($v) {
		$v = str_replace(".","",$v);
		$v = str_replace(",",".",$v);
		return $v;
	}
	
	function formata($numero){
       if(strpos($numero,'.')!='')
       {
                  $var=explode('.',$numero);
                  if(strlen($var[0])==4)
                  {
                    $parte1=substr($var[0],0,1);
                    $parte2=substr($var[0],1,3);
                    if(strlen($var[1])<2)
                    {
                       $formatado=$parte1.'.'.$parte2.','.$var[1].'0';
                    }else
                    {
                       $formatado=$parte1.'.'.$parte2.','.$var[1];
                    }
                  }
                  elseif(strlen($var[0])==5)
                  {
                    $parte1=substr($var[0],0,2);
                    $parte2=substr($var[0],2,3);
                    if(strlen($var[1])<2)
                    {
                       $formatado=$parte1.'.'.$parte2.','.$var[1].'0';
                    }
                    else
                    {
                       $formatado=$parte1.'.'.$parte2.','.$var[1];
                    }
                  }
                  elseif(strlen($var[0])==6)
                  {
                    $parte1=substr($var[0],0,3);
                    $parte2=substr($var[0],3,3);
                    if(strlen($var[1])<2)
                    {
                       $formatado=$parte1.'.'.$parte2.','.$var[1].'0';
                    }
                    else
                    {
                       $formatado=$parte1.'.'.$parte2.','.$var[1];
                    }
                  }
                  elseif(strlen($var[0])==7)
                  {
                    $parte1=substr($var[0],0,1);
                    $parte2=substr($var[0],1,3);
                    $parte3=substr($var[0],4,3);
                    if(strlen($var[1])<2)
                    {
                       $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1].'0';
                    }
                    else
                    {
                    $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1];
                    }
                  }
                  elseif(strlen($var[0])==8)
                  {
                    $parte1=substr($var[0],0,2);
                    $parte2=substr($var[0],2,3);
                    $parte3=substr($var[0],5,3);
                    if(strlen($var[1])<2){
                    $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1].'0';
                    }else{
                    $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1];
                    }
                  }
                  elseif(strlen($var[0])==9)
                  {
                    $parte1=substr($var[0],0,3);
                    $parte2=substr($var[0],3,3);
                    $parte3=substr($var[0],6,3);
                    if(strlen($var[1])<2)
                    {
                       $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1].'0';
                    }
                    else
                    {
                       $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1];
                    }
                  }
                  elseif(strlen($var[0])==10)
                  {
                    $parte1=substr($var[0],0,1);
                    $parte2=substr($var[0],1,3);
                    $parte3=substr($var[0],4,3);
                    $parte4=substr($var[0],7,3);
                    if(strlen($var[1])<2)
                    {
                       $formatado=$parte1.'.'.$parte2.'.'.$parte3.'.'.$parte4.','.$var[1].'0';
                    }
                    else
                    {
                       $formatado=$parte1.'.'.$parte2.'.'.$parte3.'.'.$parte4.','.$var[1];
                    }
                  }
                  else
                  {
                    if(strlen($var[1])<2)
                    {
                        $formatado=$var[0].','.$var[1].'0';
                    }
                    else
                    {
                        $formatado=$var[0].','.$var[1];
                    }
                  }
         }
         else
         {
            $var=$numero;
          if(strlen($var)==4)
          {
            $parte1=substr($var,0,1);
            $parte2=substr($var,1,3);
            $formatado=$parte1.'.'.$parte2.','.'00';
          }
          elseif(strlen($var)==5)
          {
            $parte1=substr($var,0,2);
            $parte2=substr($var,2,3);
            $formatado=$parte1.'.'.$parte2.','.'00';
          }
          elseif(strlen($var)==6)
          {
            $parte1=substr($var,0,3);
            $parte2=substr($var,3,3);
            $formatado=$parte1.'.'.$parte2.','.'00';
          }
          elseif(strlen($var)==7)
          {
            $parte1=substr($var,0,1);
            $parte2=substr($var,1,3);
            $parte3=substr($var,4,3);
            $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.'00';
          }
          elseif(strlen($var)==8)
          {
            $parte1=substr($var,0,2);
            $parte2=substr($var,2,3);
            $parte3=substr($var,5,3);
            $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.'00';
          }
          elseif(strlen($var)==9)
          {
            $parte1=substr($var,0,3);
            $parte2=substr($var,3,3);
            $parte3=substr($var,6,3);
            $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.'00';
          }
          elseif(strlen($var)==10)
          {
            $parte1=substr($var,0,1);
            $parte2=substr($var,1,3);
            $parte3=substr($var,4,3);
            $parte4=substr($var,7,3);
            $formatado=$parte1.'.'.$parte2.'.'.$parte3.'.'.$parte4.','.'00';
          }
          else
          {
            $formatado=$var.','.'00';
          }
       }
         return $formatado;
}

	
	
	function formata_hora($hora){
		if (strlen($hora)==1)
			$hora = '0'.$hora;
		return $hora.':00';
	}
	
	function reduz_imagem($img, $max_x, $max_y, $nome_foto) {
		//pega o tamanho da imagem ($original_x, $original_y)
		list($width, $height) = getimagesize($img);
		
		$original_x = $width;
		$original_y = $height;
		
		// se a largura for maior que altura
		if($original_x > $original_y) {
		   $porcentagem = (100 * $max_x) / $original_x;      
		}
		else {
		   $porcentagem = (100 * $max_y) / $original_y;  
		}
		
		$tamanho_x = $original_x * ($porcentagem / 100);
		$tamanho_y = $original_y * ($porcentagem / 100);
		
		$image_p = imagecreatetruecolor($tamanho_x, $tamanho_y);
		$image   = imagecreatefromjpeg($img);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $tamanho_x, $tamanho_y, $width, $height);
		
		
		return imagejpeg($image_p, $nome_foto, 90);
	}
	
	/*
	 * Funcao que pesquisa se um uma valor se encontra dentro de um array 
	 * Parametros: array: array a ser pesquisado o valor
	 * 			   valor: valor que deseja verificar se encontra-se dentro do array
	 */
	function pesquisaCheck($valor, $array){
		for($i=0; $i<count($array);$i++)
			if ($valor == $array[$i])
				return true; 
	}
	
	//FUNCAO QUE RETORNA O ID DO MORADOR
	function consultarId($id){
		$banco = new bd();
		$banco->conectar();
		$db = &$banco->adodb;
		$sql = "SELECT a.id 
			FROM
			tb005_moradores a, tb001_usuarios b
			WHERE
			a.tb001_usuarios_id = b.id
			AND
			b.id = $id";
		$rs_sql = &$db->Execute($sql) or die ($db->ErrorMsg());
		return $rs_sql->fields["id"];
	}
	
	//FUNÇOES PARA CODIFICAR OS PARAMETROS EM GET
	//CRIPTOGRAFAR
	function b3cript($url){
		
		$code = new cast128();
		$code->setkey($_SESSION['PHPSESSID']);
		return urlencode(base64_encode($code->encrypt($url)));
	}
	
	//DESCRIPTOGRAFAR
	function b3decript($codigo) {
		$code = new cast128();
		$code->setkey($_SESSION['PHPSESSID']);
		$decript = $code->decrypt(base64_decode($codigo));
		if (urldecode(b3cript($decript)) != $codigo){
			exit("<script>alert('Endereço Inválido');history.back();</script>");
		}
		$parametros = explode("&", $decript);
		
		for ($i=0; $i<count($parametros); $i++){
			$valor = explode("=", trim( urldecode( strip_tags( $parametros[$i] ) ) ) );
			$_GET[ $valor[0] ] = $valor[1];
		}
	}
	function redirect($url){
		echo "<script> window.location = '$url'</script>";
	}
	
	function ajustaData($data){
		$data_new = explode('-',$data);
		$dia = explode(' ',$data_new[2]);
		echo $dia[0].'/'.$data_new[1].'/'.$data_new[0];
	}
	
	// Colocando ponto a cada 3 casas, Recebendo o valor por parametro
	function guarani($input){
	if(strlen($input)<=3)
	{ return $input; }
	$length=substr($input,0,strlen($input)-3);
	$formatted_input = guarani($length).'.'.substr($input,-3);
	return $formatted_input;
	}
	// numero a ser passado por parametro
	//$num = $regw_cambio['vl_cambio'] * 10;
	// imprimindo o valor
	//echo guarani($regw_cambio['vl_cambio'] * 10);// resultado 1.234.567	
	
	##################################################################################################	
// descricao.........: esta função recebe um valor numérico e retorna uma 
//                     string contendo o valor de entrada por extenso
// parametros entrada: $valor (formato que a função number_format entenda :)
// parametros saída..: string com $valor por extenso

function extensoguarani($valor=0) {
	$singular = array("CENTAVO", "GUARANI", "MIL", "MILLON", "BILLON", "TRILLON", "QUATRILLON");
	$plural = array("CENTAVOS", "GUARANIES", "MIL", "MILLONES", "BILLONES", "TRILLONES",
"QUATRILLONES");

	$c = array("", "CINE", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS",
"QUINIENTOS", "SEICIENTOS", "SIETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS");
	$d = array("", "DIEZ", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA",
"SESENTA", "SETENTA", "OCHENTA ", "NOVENTA");
	$d10 = array("DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE",
"DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE");
	$u = array("", "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS",
"SIETE", "OCHO", "NUEVE");

	$z=0;

	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
	for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];

	// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
	for ($i=0;$i<count($inteiro);$i++) {
		$valor = $inteiro[$i];
		$rc = (($valor > 100) && ($valor < 200)) ? "CENTO" : $c[$valor[0]];
		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
	
		$r = $rc.(($rc && ($rd || $ru)) ? " Y " : "").$rd.(($rd &&
$ru) ? " Y " : "").$ru;
		$t = count($inteiro)-1-$i;
		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if ($valor == "000")$z++; elseif ($z > 0) $z--;
		if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " DE " : "").$plural[$t]; 
		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " Y ") : " ") . $r;
	}

	return($rt ? $rt : "zero");
}

/**
 * Esta função retorna uma data escrita da seguinte maneira:
 * Exemplo: Terça-feira, 17 de Abril de 2007
 * @author Leandro Vieira Pinho [http://leandro.w3invent.com.br]
 * @param string $strDate data a ser analizada; por exemplo: 2007-04-17 15:10:59
 * @return string
 */
function formata_data_extenso($strDate)
{
	// Array com os dia da semana em português;
	$arrDaysOfWeek = array('Domingo','lunes','martes','miercoles','jueves','viernes','sabado');
	// Array com os meses do ano em português;
	$arrMonthsOfYear = array(1 => 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	// Descobre o dia da semana
	$intDayOfWeek = date('w',strtotime($strDate));
	// Descobre o dia do mês
	$intDayOfMonth = date('d',strtotime($strDate));
	// Descobre o mês
	$intMonthOfYear = date('n',strtotime($strDate));
	// Descobre o ano
	$intYear = date('Y',strtotime($strDate));
	// Formato a ser retornado
	return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
}
function formata_data_extensob($strDate)
{
	// Array com os dia da semana em português;
	$arrDaysOfWeek = array('Domingo','lunes','martes','miercoles','jueves','viernes','sabado');
	// Array com os meses do ano em português;
	$arrMonthsOfYear = array(1 => 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	// Descobre o dia da semana
	$intDayOfWeek = date('w',strtotime($strDate));
	// Descobre o dia do mês
	$intDayOfMonth = date('d',strtotime($strDate));
	// Descobre o mês
	$intMonthOfYear = date('n',strtotime($strDate));
	// Descobre o ano
	$intYear = date('Y',strtotime($strDate));
	// Formato a ser retornado
	return $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
}


?>