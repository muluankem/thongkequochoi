<?php
	/*
	Duong Xuan Hoa va Ha Thi Minh Tam bi loi
	*/
	ini_set('max_execution_time', 1000);
	include("function.php");
	connect();

	/*if (isset($_POST["addspeech"]))
	{
		$required = array('speaker', 'delegation', 'header', 'content','time','date');

		$error = false;
		foreach($required as $field) 
		{
  			if (empty($_POST[$field])) 
  			{
    			$error = true;
  			}
		}

		if ($error)
			echo "All fields are required.";
		else
		{

			$speaker=protect($_POST["speaker"]);
			$delegation=protect($_POST["delegation"]);
			$header=protect($_POST["header"]);
			$content=protect($_POST["content"]);
			$time=protect($_POST["time"]);
			$date=protect($_POST["date"]);

			$speakerID=getID("delegate",$speaker);
			$delegationID=getID("delegation" ,$delegation);
			$headerID=getID("header",$header);
			$timeID=getID("time",$time);

		
			$sql="INSERT INTO speech (speaker,delegation,header,content,`time`,`date`) VALUES ($speakerID,$delegationID,$headerID,'$content',$timeID,'$date')";
			$res=mysql_query($sql) or die(mysql_error());
			header("Location: admin.php");
		}
	}*/

	$fin=fopen("input.txt","r") or die("Unable to open file!");
	//$fout=fopen("output.txt","w") or die("Unable to open file!");
	$header=protect(fgets($fin));
	$time=protect(fgets($fin));
	$date=protect(fgets($fin));
	$typeID=protect(fgets($fin));
	do
	{
		do
		{
			$s=protect(fgets($fin));
		}
		while (strlen($s)<=2 and !feof($fin));
		if (feof($fin)) break;
		$flag=true;
		$speaker="";
		$delegation="";
		for ($i=0; $i<strlen($s); $i++)
		{
			if (substr($s,$i,3)==" - " and $flag) 
			{
				$flag=false;
				$i+=2;
			}
			else
			{
				if ($flag) $speaker=$speaker.substr($s,$i,1);
				else $delegation=$delegation.substr($s,$i,1);
			}
		}

		if (strlen($delegation)==0) continue;
		$content="";
		do
		{
			//$prevp=$p;
			$p=protect(fgets($fin));
			//echo (strlen($p));
			if (strlen($p)==2 or strlen($p)==0) break;
			$content=$content."<p>".$p."</p>";
		}
		while (true);

		$speakerID=getID("delegate",$speaker);
		$delegationID=getID("delegation" ,$delegation);
		$headerID=getID("header",$header);
		$timeID=getID("time",$time);

		$sql="SELECT id from speech WHERE speaker=$speakerID and delegation=$delegationID and header=$headerID and content='$content' and `time`=$timeID and `date`='$date' and type=$typeID";
		//echo $sql."<br>";
		$res=mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($res)>0)
			echo "Domument inserted.<br>";
		else
		{
			$sql="INSERT INTO speech (speaker,delegation,header,content,`time`,`date`,type) VALUES ($speakerID,$delegationID,$headerID,'$content',$timeID,'$date',$typeID)";
			//fwrite($fout,"$sql\n");
			//echo $sql."<br>";
			echo $speaker." - ".$delegation."<br>";
			$res=mysql_query($sql) or die(mysql_error());
		}

	}
	while (!feof($fin));

	fclose($fin);
	echo "Finish";
	//fclose($fout);
?>
