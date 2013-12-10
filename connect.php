<?php
$myServer = "192.168.1.102";
$myUser = "sa";
$myPass = "1234";
$myDB = "Ai_account";
$connectionInfo = array("database"=>"ai_account","uid"=>"ai_account","pwd"=>"1234");

//connection to the database
$dbhandle = sqlsrv_connect($myServer, $connectionInfo)
or die("Couldn't connect to SQL Server on $myServer");
foreach($connectionInfo as $key=>$value)
{
	echo "$key : $value <br>";
}

/*

//select a database to work with
$selected = sqlsrv_select_db($myDB, $dbhandle)
or die("Couldn't open database $myDB");

//declare the SQL statement that will query the database
$query = "select * from sysobjects where xtype='u'";

//execute the SQL query and return records
$result = sqlsrv_query($query);

$numRows = sqlsrv_num_rows($result);
echo "<h1>" . $numRows . " Row" . ($numRows == 1 ? "" : "s") . " Returned </h1>";

//display the results
while($row = sqlsrv_fetch_array($result))
{
echo "<li>" . $row["id"] . $row["name"] . "</li>";
}
//close the connection
sqlsrv_close($dbhandle);

?>*/