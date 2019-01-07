<?php
	include("function.php");
	include("header.php");
	connect();

	if (isset($_GET["time"]) and isset($_GET["date"]) and isset($_GET["id"]))
	{
		$idHeader=protect($_GET["id"]);
		$idTime=protect($_GET["time"]);
		$date=protect($_GET["date"]);
		?>
		<title>Thống kê Quốc hội khóa XIV - <?php 
			echo getName("header",$idHeader)." - ";
			echo getName("time",$idTime)." ngày ".date("d",strtotime($date))." tháng ".date("m",strtotime($date))." năm ".date("Y",strtotime($date));
			?>
		</title>
		<?php
		echo "<h3>";
		printSession($idTime,$date,$idHeader);
		echo "</h3>";
		echo getName("time",$idTime)." "." ngày ".date("d",strtotime($date))." tháng ".date("m",strtotime($date))." năm ".date("Y",strtotime($date))."<br><br>";
		?>
		<form action="session.php" method="get">
		Đại biểu: <input type="text" name="delegate" value="<?php echo $_GET["delegate"]; ?>">
		Đoàn: <input type="text" name="delegation" value="<?php echo $_GET["delegation"]; ?>">
		<input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
		<input type="hidden" name="time" value="<?php echo $_GET["time"]; ?>">
		<input type="hidden" name="date" value="<?php echo $_GET["date"]; ?>">
		<input type="submit" name="submit" value="Tìm bài phát biểu">
		</form>
		<?php
		if (strlen($_GET["delegate"])==0 and strlen($_GET["delegation"])==0)
		{
			$sql="SELECT id,speaker,delegation,content from speech WHERE (header=$idHeader and `time`=$idTime and `date`='$date') ORDER BY id ASC";
			$res=mysql_query($sql) or die(mysql_error());
			while ($get=mysql_fetch_assoc($res))
			{
				echo "<h4>";
				printLink("delegate",$get["speaker"]);
				echo " - ";
				printLink("delegation",$get["delegation"]);
				echo "</h4>";
				echo $get["content"];
				?>
				<div class="fb-like" data-href="http://www.thongkequochoi.ga/speech.php?id=<?php echo $get["id"]; ?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
				<?php
			}
		}
		else
		{
			if (strlen(protect($_GET["delegate"]))>0)
				$delegateSet=getIDSet("delegate",protect($_GET["delegate"]));
			if (strlen(protect($_GET["delegation"]))>0)
				$delegationSet=getIDSet("delegation",protect($_GET["delegation"]));

			$sql="SELECT id,speaker,delegation,content from speech WHERE header=$idHeader and `time`=$idTime and `date`='$date'";
			$flag=true;

			if (isset($delegateSet) and $delegateSet!="(0)")
			{
				if ($flag) $sql=$sql." AND ";
				else $flag=true;
				$sql=$sql." speaker in $delegateSet";
			}

			if (isset($delegationSet) and $delegationSet!="(0)")
			{
				if ($flag) $sql=$sql." AND ";
				else $flag=true;
				$sql=$sql." delegation in $delegationSet";
			}

			$sql=$sql." ORDER BY id ASC";
			//echo $sql;
			$res=mysql_query($sql) or die(mysql_error());
			while ($get=mysql_fetch_assoc($res))
			{
				echo "<h4>";
				printLink("delegate",$get["speaker"]);
				echo " - ";
				printLink("delegation",$get["delegation"]);
				echo "</h4>";
				echo $get["content"];
				?>
				<div class="fb-like" data-href="http://www.thongkequochoi.ga/speech.php?id=<?php echo $get["id"]; ?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
				<?php
			}

		}
	}
	include("footer.php");
?>