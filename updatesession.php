<?php
	connect();

	$sql1="SELECT header,`time`,`date` from speech";
	$res1=mysql_query($sql1) or die(mysql_error());

	while ($get1=mysql_fetch_assoc($res1))
	{
		echo $get1["header"]."\n";
		$header=$get1["header"];
		$time=$get1["time"];
		$date=$get1["date"];
		$sql2="SELECT id from session WHERE header=$header AND `time`=$time AND `date`='$date'";
		$res2=mysql_query($sql2) or die(mysql_error());
		if (mysql_num_rows($res2)==0)
		{
			$sql3="INSERT INTO session (header,`time`,`date`) VALUES ($header,$time,'$date')";
			$res3=mysql_query($sql3) or die(mysql_error());
		}
	}

	$sql1="SELECT id from session ORDER BY `date` DESC, `time` DESC";
	$res1=mysql_query($sql1) or die(mysql_error());
	$stt=0;

	while ($get1=mysql_fetch_assoc($res1))
	{
		$idSession=$get1["id"];
		echo $idSession."\n";
		$stt++;
		$sql2="UPDATE session SET rank=$stt WHERE id=$idSession";
		$res2=mysql_query($sql2) or die(mysql_error());
	}
?>