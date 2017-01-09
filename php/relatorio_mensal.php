<?php
require_once("../biblioteca.php");
include "../config.php";
include "../ChromePhp.php";
conexao();
//ChromePhp::log('Hello console!');
//ChromePhp::log($_SERVER);
//ChromePhp::warn('something went wrong!');
$acao = $_POST['acao'];
//$ano = $_POST['ano'];
//$mes = $_POST['mes'];

$ano = $_POST['ano'];
$mes = $_POST['mes'];

 if($acao == "RelMensal"){
    
$arr = array();

$TotalVendas = 0.00;
$TotalForn = 0.00;
$TotalCompras = 0.00;
$TotalRec = 0.00;
$TotalDesp = 0.00;
$TotalLiq = 0.00;


    $sql_venda = "SELECT sum(round(p.total_nota,2)) AS VendasVista, 
				  (SELECT sum((p.total_nota)) FROM pedido p WHERE YEAR(p.data_car) = '$ano' AND MONTH(p.data_car) = '$mes' 
				  AND forma_pagamento_id > '1' AND p.status != 'C' AND p.situacao = 'F' )  AS VendasPrazo,
				  (SELECT sum(round(cp.vl_parcela - cp.vl_pago,2)) FROM compras c, contas_pagar cp WHERE YEAR(c.data_lancamento) = '$ano'
				  AND MONTH(c.data_lancamento) = '$mes' AND cp.compra_id = c.id_compra AND cp.lanc_desp_id = '0' 
				  AND  YEAR(cp.dt_pgto_parcela) = '0000' AND cp.status = 'A')  AS ComprasPrazo,
				  (SELECT sum(lc.valor) FROM lancamento_caixa lc, compras c WHERE YEAR(lc.data_lancamento) = '$ano'
				  AND MONTH(lc.data_lancamento) = '$mes' AND lc.venda_id = c.id_compra AND lc.lanc_despesa_id = '0' AND lc.receita_id = '2')  AS ComprasVista
				  FROM pedido p
                  WHERE YEAR(p.data_car) = '$ano' AND MONTH(p.data_car) = '$mes' AND forma_pagamento_id = '1' AND p.status != 'C'
                  AND p.situacao = 'F'  ";
    $exe_venda = mysql_query($sql_venda)or die (mysql_error().'-'.$sql_venda);
    while ($reg_venda = mysql_fetch_array($exe_venda, MYSQL_ASSOC)){
    
		//echo   $TotalCompras += ($reg_venda['TotalCompras']);
    $VendasVista += ($reg_venda['VendasVista']);
	$VendasPrazo = ($reg_venda['VendasPrazo']);
	$ComprasPrazo = ($reg_venda['ComprasPrazo']);
	$ComprasVista = ($reg_venda['ComprasVista']);
	
	$TotalVendas = $VendasVista + $VendasPrazo;
    $TotalCompras = $ComprasPrazo + $ComprasVista;
    }
    
    $sql_caixa = "SELECT sum(lc.vl_pago) AS vl_pago FROM lancamento_caixa_balcao lc, contas_receber cr  WHERE YEAR(lc.dt_lancamento) = '$ano' AND MONTH(lc.dt_lancamento) = '$mes' 
	AND lc.contas_receber_id = cr.id  ";
    $exe_caixa = mysql_query($sql_caixa)or die (mysql_error());
    $reg_caixa = mysql_fetch_array($exe_caixa, MYSQL_ASSOC);
    $CartReceber = $reg_caixa['vl_pago'];

	$sql_caixax = "SELECT sum(lb.valor) AS valor,
	(SELECT sum(lc.valor) FROM lancamento_caixa lc, lanc_despesa ld, contas_pagar cp WHERE YEAR(lc.data_lancamento) = '$ano'
	AND MONTH(lc.data_lancamento) = '$mes' AND lc.contas_pagar_id = cp.id AND cp.lanc_desp_id = ld.id_lanc_despesa ) AS PagoDesp,
	(SELECT sum(valor) FROM lancamento_caixa WHERE YEAR(data_lancamento) = '$ano' AND MONTH(data_lancamento) = '$mes' AND historico = 'Retirada Socio') AS TotalRet
	FROM lancamento_caixa lb, contas_pagar cp
	WHERE YEAR(lb.data_lancamento) = '$ano' AND MONTH(lb.data_lancamento) = '$mes' 
	AND lb.contas_pagar_id = cp.id AND lb.despesa_cod = '0' AND cp.compra_id != '0' ";
	ChromePhp::log($sql_caixax);
    $exe_caixax = mysql_query($sql_caixax)or die (mysql_error());
    $reg_caixax = mysql_fetch_array($exe_caixax, MYSQL_ASSOC);
    $CartPagar = $reg_caixax['valor'];
	$PagoDesp = $reg_caixax['PagoDesp'];
    $TotalRet = $reg_caixax['TotalRet'];

	
    $sql_desp = "SELECT round(sum(d.valor)) AS valor FROM lanc_despesa d WHERE YEAR(d.dt_lanc_desp) = '$ano' 
                            AND MONTH(d.dt_lanc_desp) = '$mes'  ";
    $exe_desp = mysql_query($sql_desp) or die (mysql_error());
    $reg_desp = mysql_fetch_array($exe_desp, MYSQL_ASSOC);
    $TotalDesp = $reg_desp['valor'];
    
    $Gastos = $TotalDesp + $TotalForn;
	$TotalEnt = $VendasVista + $CartReceber;
	$TotalForn = $CartPagar;
    $TotalSaidas = $CartPagar + $PagoDesp + $TotalRet;
            
    $arr = array('VendasVista'=> number_format($VendasVista,2,",","."), 'TotalEnt'=> number_format($TotalEnt,2,",","."), 
				'TotalVendas'=> number_format($TotalVendas,2,",","."),
				'TotalCompras'=> number_format($TotalCompras,2,",","."),
                'TotalDesp'=> number_format($TotalDesp,2,",","."), 
				'CartPagar'=> number_format($CartPagar,2,",","."), 
				'PagoDesp'=> number_format($PagoDesp,2,",","."),
				'TotalRet'=> number_format($TotalRet,2,",","."),
				'CartReceber'=> number_format($CartReceber,2,",","."),
				'TotalSaidas'=> number_format($TotalSaidas,2,",","."));
   
    echo '({"results":'.json_encode($arr).'})'; 

}


?>

