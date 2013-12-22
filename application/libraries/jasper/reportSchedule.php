<?php

	require_once("ReportSchedulerService.php");

	session_start();
	$username = $_SESSION["username"];
	$password = $_SESSION["password"];
	if (!isset($username))
	{
		header("Location: index.php");
		exit();
	}
			
	$reportSchedulerService = new ReportSchedulerService($SCHEDULING_WS_URI, $username, $password);
	
	$reportURI = $_GET["reportURI"];
	$parentURI = substr($reportURI, 0, strrpos($reportURI, "/"));
	$jobs = $reportSchedulerService->getReportJobs($reportURI);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JasperServer Web Services Sample</title>
    </head>
    <body>

    <center><h1>JasperServer Web Services Sample</h1></center>
    <hr/>
    <h3>List report jobs</h3>
    Report: <?php echo $reportURI ?><br>
    <br/>
    <table id="mainTable" border="2" cellpadding="2" cellspacing="2" height="100%" valign="top">
    <tr>
    	<td align="center">Id</td>
    	<td align="center">Label</td>
    	<td align="center">State</td>
    	<td align="center">Last ran at</td>
    	<td align="center">Next run time</td>
    <tr>
<?php
	if ($jobs != null) 
	foreach ($jobs as $job)
	{
?>
    <tr>
    	<td><?php echo $job->id ?></td>
    	<td><?php echo $job->label ?></td>
    	<td><?php echo $job->state->enc_value ?></td>
    	<td><?php echo $job->previousFireTime ?></td>
    	<td><?php echo $job->nextFireTime ?></td>
    </tr>
<?php
	}
?>
     </table>
     <br/>
     <a href="reportJob.php?reportURI=<?php echo $reportURI ?>">Schedule new job</a>
     <hr/>
     <a href="listReports.php?uri=<?php echo $parentURI ?>">Back to repository</a>
     <br/>
     <a href="index.php">Exit</a>
    </body>
</html>
