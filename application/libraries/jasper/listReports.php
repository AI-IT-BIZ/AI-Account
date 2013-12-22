<?php

 require_once('client.php');

 session_start();
 if ($_SESSION["username"] == '')
 {
 	header("Location: index.php");
     	exit();
 }

 $currentUri = "/";
 $parentUri = "/";

 if ($_GET['uri'] != '')
 {
 	$currentUri = $_GET['uri'];
 }


   $pos = strrpos($currentUri, "/");
   if($pos === false || $pos == 0) {
        $parentUri="/";
   }
   else
   {
   	 $parentUri = substr($currentUri, 0, $pos );
   }

 $result = ws_list($currentUri);
if (is_soap_fault($result))
 {
 	$errorMessage = $result->getFault()->faultstring;
 }
 else
 {
 	$folders = getResourceDescriptors($result);
 }



 ?>


 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Jaspersoft PHP Sample</title>
    </head>
    <body>

    <h1>List report</h1>

    Current Directory: <?php echo $currentUri; ?><br>
    <br>
    <a href="?uri=<?php echo $parentUri; ?>">[..]</a><br>

	<table border="1" cellpadding="3">
    <?php
       for ($i=0; $i < count($folders); ++$i)
       {
       	    $resource = $folders[$i];

    	    if ( $resource['type'] == 'folder')
    	    {
    		?>
    		<tr>
    			<td>
    				<a href="?uri=<?php echo $resource['uri']; ?>">[<?php echo $resource['label']; ?>]</a>
    			</td>
    			<td>
    				<?php if (isset($resource['creationDate'])) echo date('Y-m-d H:i', $resource['creationDate']); ?>
    			</td>
    			<td>&nbsp;</td>
    		</tr>
    		<?php
            }
            else if ( $resource['type'] == 'reportUnit')
    	    {
    		?>
    		<tr>
    			<td>
    				<a href="runReport.php?uri=<?php echo $resource['uri']; ?>"><?php echo $resource['label']; ?></a>
    			</td>
    			<td>
    				<?php if (isset($resource['creationDate'])) echo date('Y-m-d H:i', $resource['creationDate']); ?>
    			</td>
    			<td>
    				<a href="reportSchedule.php?reportURI=<?php echo $resource['uri'] ?>">Schedule</a>
    			</td>
    		</tr>
    		<?php
            }
       }
    ?>
    </table>
     <br>
     <br>
     <hr>
     <a href="index.php">Exit</a>
    </body>
</html>
