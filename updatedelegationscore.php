<?php
	connect();


	$sql1="SELECT id from delegation";
	$res1=mysql_query($sql1) or die(mysql_error());

	while ($get1=mysql_fetch_assoc($res1))
	{
		$idDelegation=$get1["id"];
		echo $idDelegation."\n";
		$sql2="SELECT id from delegate WHERE delegation=$idDelegation";
		$res2=mysql_query($sql2) or die(mysql_error());

		$num=mysql_num_rows($res2);

		$sql3="UPDATE delegation SET num=$num WHERE id=$idDelegation";
		$res3=mysql_query($sql3) or die(mysql_error());

		$sql4="SELECT id from speech WHERE delegation=$idDelegation";
		$res4=mysql_query($sql4) or die(mysql_error());

		$sum=mysql_num_rows($res4);

		$sql5="UPDATE delegation SET sum=$sum WHERE id=$idDelegation";
		$res5=mysql_query($sql5) or die(mysql_error());
	}

	$sql1="SELECT id from delegation ORDER BY sum DESC, num ASC";
	$res1=mysql_query($sql1) or die(mysql_error());
	$stt=0;
	while ($get1=mysql_fetch_assoc($res1))
	{
		$idDelegation=$get1["id"];
		$stt++;
		echo $stt."\n";
		$sql2="UPDATE delegation SET rank=$stt WHERE id=$idDelegation";
		$res2=mysql_query($sql2) or die(mysql_error());
	}
?>