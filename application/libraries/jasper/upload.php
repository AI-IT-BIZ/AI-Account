<?php

 require_once('client.php');

 session_start();
 if ($_SESSION["username"] == '')
 {
 	header("Location: index.php");
     	exit();
 }

 $result = ws_put();
if (is_soap_fault($result))
 {

 	$errorMessage = $result->getFault()->faultstring;
 	echo htmlspecialchars( $errorMessage );
 }
 else
 {
 	echo "<pre>";
		echo htmlspecialchars( $result );
		echo "</pre>";
 }
?>
