<?php
	connect();
	$sql1="SELECT id from delegate";
	$res1=mysql_query($sql1) or die(mysql_error());
	$stt=0;
	while ($get1=mysql_fetch_assoc($res1))
	{
		$stt++;
		echo $stt."\n";
		updateSpeakTime($get1["id"]);
	}
	$sql1="SELECT id,score from delegate ORDER BY score DESC";
	$res1=mysql_query($sql1) or die(mysql_error());
	$stt=0;
	while ($get1=mysql_fetch_assoc($res1))
	{
		$stt++;
		echo $stt."\n";
		updateRank($get1["id"],$stt);
	}
?>