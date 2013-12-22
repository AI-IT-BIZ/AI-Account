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
	
	$job = new Job();
	$reportURI = $_POST["reportURI"];
	$job->reportUnitURI = $reportURI;
	$job->label = $_POST["label"];
	$job->baseOutputFilename = $_POST["outputName"];
	$job->outputFormats = $_POST["output"];
   
	$repoDest = new JobRepositoryDestination();
	$repoDest->folderURI = "/ContentFiles"; //hardcoded!
	$repoDest->sequentialFilenames = isset($_POST["sequential"]);
	$job->repositoryDestination = $repoDest;
   
	$trigger = new JobSimpleTrigger();
	$trigger->occurrenceCount = -1; //recur indefinitely
	$trigger->recurrenceInterval = $_POST["interval"];
	$trigger->recurrenceIntervalUnit = $_POST["intervalUnit"];
	$job->simpleTrigger = $trigger;

	$mailTo = $_POST["mailTo"];
	if ($mailTo != "")
	{
		$mail = new JobMailNotification();
		$mail->toAddresses = array($mailTo);
		$mail->subject = "Reports";
		$mail->messageText = "Some reports";
		$mail->resultSendType = ResultSendType::SEND;
		$job->mailNotification = $mail;
	}
	
	$savedJob = $reportSchedulerService->scheduleJob($job);
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
    <h3>Saved job <?php echo $savedJob->id ?>.</h3>
     <hr/>
     <a href="reportSchedule.php?reportURI=<?php echo $reportURI ?>">Back</a>
    <br/>
     <a href="index.php">Exit</a>
    </body>
</html>
