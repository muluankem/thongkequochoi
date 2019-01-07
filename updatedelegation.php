<?php
	connect();

	$sql1="SELECT id from delegate";
	$res1=mysql_query($sql1) or die(mysql_error());

	while ($get1=mysql_fetch_assoc($res1))
	{
		$idDelegate=$get1["id"];
		$sql2="SELECT delegation from speech WHERE speaker=$idDelegate ORDER BY `date` DESC, `time` DESC";
		$res2=mysql_query($sql2) or die(mysql_error());
		if (mysql_num_rows($res2)!=0)
		{
			$get2=mysql_fetch_array($res2);
			$idDelegation=$get2["delegation"];
			$sql3="UPDATE delegate SET delegation=$idDelegation WHERE id=$idDelegate";
			$res3=mysql_query($sql3) or die(mysql_error());
			echo getName("delegate",$idDelegate)." - ".getName("delegation",$idDelegation)."<br>";
		}
	}
?>