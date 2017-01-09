<?php
/**
 * Arduino + PHP
 *
 * @author  Bruno Soares
 * @website www.bsoares.com.br
 */

$comando = '$0R10x0D';

$port = fopen('COM1', 'w+');
fwrite($port, '');
fclose($port);


//if (isset($comando) && !empty($comando)) {
 //   $comando = hexdec($comando);
    $message = $comando;

    // USB Serial Port (COM1)
    $portAddress = 'COM1';
   
    // Open connection on port
    $port = fopen($portAddress, 'w+');
   
    // Necessary when the Arduino reset after the connection
    //sleep(2);
   
    // Send chars
    fwrite($port, $message);
   
    // Close connection
    fclose($port);
//}
?>