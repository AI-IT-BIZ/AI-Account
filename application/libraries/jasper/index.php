<?php

   require_once('client.php');

   $errorMessage = "";

   $username = $_POST['username'];
   $password = $_POST['password'];

   if ($username != '')
   {
        $result = ws_checkUsername($username, $password);

if (is_soap_fault($result))
        {
            $errorMessage = $result->getFault()->faultstring;
        }
        else
       {
            session_start();
                session_unset();
            session_register("username");
            session_register("password");
            $_SESSION["username"]=$username;
            $_SESSION["password"]=$password;
            header("location: listReports.php");
                exit();
       }
   }


?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>PHP Sample</title>
    </head>
    <body>

    <h2>Welcome to the JasperReports Server sample (PHP version)</h2>

   <h2><font color="red"><?php echo $errorMessage; ?></font></h2>

	<img src="images/js-logo.gif" alt="Jaspersoft Logo" />

   <form action="index.php" method=POST>

       Type in a JasperServer username and password (i.e. jasperadmin/jasperadmin)<br><br>
	<table>
	<tr>
	<td>Username</td>
	<td><input type="text" name="username"></td>
      	</tr>
	<tr>
	<td>Password</td>
	<td><input type="password" name="password"></td>
	</tr>
	</table>

       <br>
       <input type="submit" value="Enter">

   </form>



    </body>
</html>
