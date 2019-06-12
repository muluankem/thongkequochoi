<?php
	
	
	function connect()
	{
		if (!mysql_connect("localhost","root",""))
		{
			mysql_connect("localhost","root","");
			mysql_select_db("quochoi");
			//error_reporting(0);
		}
		else
		{
			//error_reporting(0);
			mysql_select_db("quochoi");
		}
		mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	}
	
	function protect($string)
	{
		return trim(addslashes($string)," \t\n\r\0\x0B");
	}

	function newID($tablename,$idname)
	{
		connect();
		$sql="INSERT INTO $tablename (name) VALUES ('$idname')";
		$res=mysql_query($sql) or die(mysql_error());
		
		$sql="SELECT id from $tablename WHERE name='$idname'";
		$res=mysql_query($sql) or die(mysql_error());
		$get=mysql_fetch_assoc($res);

		return $get['id'];
	}

	function getID($tablename,$idname)
	{
		connect();
		$sql="SELECT id from $tablename WHERE name='$idname'";
		$res=mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($res)==0)
			return newID($tablename,$idname);
		else
		{
			$get=mysql_fetch_assoc($res);
			if ($get['id']==401 or $get['id']==354 or $get['id']==441) return 252;
			if ($get['id']==381) return 150;
			return $get['id'];
		}
	}

	function getDelegation($idSpeaker)
	{
		connect();
		$sql1="SELECT delegation from speech WHERE speaker=$idSpeaker";
		$res1=mysql_query($sql1) or die(mysql_error());
		$get1=mysql_fetch_assoc($res1);
		$idDelegation=$get1["delegation"];
		$sql2="SELECT name from delegation WHERE id=$idDelegation";
		$res2=mysql_query($sql2) or die(mysql_error());
		$get2=mysql_fetch_assoc($res2);
		return mb_convert_encoding($get2["name"],"UTF-8");
	}

	function getSpeakTime($idSpeaker)
	{
		connect();
		$sql1="SELECT id FROM speech WHERE speaker=$idSpeaker";
		$res1=mysql_query($sql1) or die(mysql_error());
		return mysql_num_rows($res1);
	}

	function updateSpeakTime($idSpeaker)
	{
		connect();
		$speakTime=getSpeakTime($idSpeaker);
		$sql1="UPDATE delegate SET score=$speakTime WHERE id=$idSpeaker";
		$res1=mysql_query($sql1) or die(mysql_error());
	}

	function updateRank($idSpeaker,$rank)
	{
		connect();
		$sql1="UPDATE delegate SET rank=$rank WHERE id=$idSpeaker";
		$res1=mysql_query($sql1) or die(mysql_error());
	}

	function getName($table,$id)
	{
		$sql="SELECT name from $table WHERE id=$id";
		$res=mysql_query($sql) or die(mysql_error());
		$get=mysql_fetch_assoc($res);
		return mb_convert_encoding($get["name"],"UTF-8");
	}

	function printLink($table,$id)
	{
		$sql1="SELECT name from $table WHERE id=$id";
		$res1=mysql_query($sql1) or die(mysql_error());
		$get1=mysql_fetch_assoc($res1);
		?>
		<a href="<?php echo $table; ?>.php?id=<?php echo $id; ?>"> <?php echo mb_convert_encoding($get1["name"],"UTF-8"); ?></a>
		<?php
	}

	function printTimeDate($time,$date)
	{
		echo getName("time",$time)." "." ngày ".date("d",strtotime($date))." tháng ".date("m",strtotime($date))." năm ".date("Y",strtotime($date));
	}

	function printSession($time,$date,$header,$limit=1000000000)
	{
		?>
		<a href="session.php?time=<?php echo $time; ?>&date=<?php echo $date; ?>&id=<?php echo $header; ?>">
		<?php 	if (strlen(getName("header",$header))<=$limit) 
					echo getName("header",$header);
				else 
					echo substr(getName("header",$header),0,$limit-3)."...";  ?>
		</a>
		<?php
	}

	function limit($header,$limit=1000000000)
	{
		if (strlen($header)<=$limit)
			return $header;
		else
			return substr($header,0,$limit-3)."...";
	}

	function getIDSet($table,$name)
	{
		$ret="(0";
		$sql="SELECT id from $table WHERE LOWER(name) LIKE LOWER('%$name%') COLLATE utf8_bin";
		$res=mysql_query($sql) or die(mysql_error());
		while ($get=mysql_fetch_assoc($res))
			$ret=$ret.",".$get["id"];
		return $ret.")";
	}

	function printPage($sql,$page,$name)
	{
		echo "Trang: ";
		$res=mysql_query($sql) or die(mysql_error());
		$nPage=mysql_num_rows($res)/100+1;
		for ($i=1; $i<$nPage; $i++)
		{
			?>
			<a href="<?php echo $name; ?>.php?page=<?php echo $i; ?>" style="color: <?php if ($page==$i) echo "red;"; else echo "black;" ?>"><?php echo $i; ?></a>
			<?php
		}
	}


?>
