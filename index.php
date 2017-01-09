<?php
	session_start();
	$msg = $_GET['msg'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Commerce | Login</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" type="text/css" href="login/style.css" title="style" media="screen" />

<script type="text/javascript">

/* <![CDATA[ */
/*	$(document).ready(function(){
			$(".block").fadeIn(1000);				   
			$(".idea").fadeIn(1000);
			$('.idea').supersleight();
			$('#usuario').supersleight('usuario');	
			$('#senha').supersleight('senha');
	});
*/
/* ]]> */
</script>
</head>

<body>
   <div id="wrap">
   
            <div class="idea">
            <img src="login/images/logoCommerce.png" alt=""/>
           <!-- <p>Entre com usuario e Senha!</p> -->
        </div>        
<div class="block">
            <form id="form1" name="form1" action="login_controller.php?acao=login" method="post">
            <div class="left"></div>
            <div class="right">
                <div class="div-row">
                	<input type="text" id="usuario" name="usuario"  onfocus="this.value='';" onblur="if (this.value=='') {this.value='usuario';}" value="usuario" />
                                    </div>
                <div class="div-row">
                     <input type="password" id="senha" name="senha" onfocus="this.value='';" onblur="if (this.value=='') {this.value='************';}" value="************" />
                </div>
                <div class="rm-row">
					<br />
                    <p><label><? echo $msg?></label> </p>
                </div>
                <div class="send-row">
                    <button id="login" value="" type="submit" name="login"></button>
                </div>
            </div>
            </form>
			
        </div>
    </div>
</body>
</html>
