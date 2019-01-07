<title>Thống kê Quốc hội khóa XIV - Tìm bài phát biểu</title>
<?php
	include("function.php");
	include("header.php");
	connect();
?>
<form action="findspeech.php" method="get">
Từ khóa: <input type="text" name="keyword" value="<?php echo $_GET["keyword"]; ?>">
Nội dung: <input type="text" name="header" value="<?php echo $_GET["header"]; ?>">
Đại biểu: <input type="text" name="delegate" value="<?php echo $_GET["delegate"]; ?>">
Đoàn: <input type="text" name="delegation" value="<?php echo $_GET["delegation"]; ?>">
<input type="submit" name="submit" value="Tìm bài phát biểu">
</form>
<?php
	if (strlen($_GET["keyword"])>0 or strlen($_GET["header"])>0 or strlen($_GET["delegate"])>0 or strlen($_GET["delegation"])>0)
	{
		?>
		<table>
			<colgroup>
			<col span="1" style="width: ;">
       		<col span="1" style="width: ;">
       		<col span="1" style="width: ;">
       		<col span="1" style="width: 15%;">
       		<col span="1" style="width: 15%;">
       		<col span="1" style="width: 19%;">
  			</colgroup>
			<tr>
				<th></th>
				<th></th>
				<th>Nội dung</th>
				<th>Đại biểu</th>
				<th>Đoàn đại biểu</th>
				<th>Thời gian</th>
			</tr>
			<?php
				$headerName=protect($_GET["header"]);
				$headerID="(0";
				if (strlen($headerName)>0)
				{
					$sql1="SELECT id from header WHERE LOWER(name) LIKE LOWER('%$headerName%') COLLATE utf8_bin";
					$res1=mysql_query($sql1) or die(mysql_error());
					while ($get1=mysql_fetch_assoc($res1))
						$headerID=$headerID.",".$get1["id"];
				}
				$headerID=$headerID.")";

				$delegationName=protect($_GET["delegation"]);
				$delegationID="(0";
				if (strlen($delegationName)>0)
				{
					$sql1="SELECT id from delegation WHERE LOWER(name) LIKE LOWER('%$delegationName%') COLLATE utf8_bin";
					$res1=mysql_query($sql1) or die(mysql_error());
					while ($get1=mysql_fetch_assoc($res1))
						$delegationID=$delegationID.",".$get1["id"];
				}
				$delegationID=$delegationID.")";

				$delegateName=protect($_GET["delegate"]);
				$delegateID="(0";
				if (strlen($delegateName)>0)
				{
					$sql1="SELECT id from delegate WHERE LOWER(name) LIKE LOWER('%$delegateName%') COLLATE utf8_bin";
					$res1=mysql_query($sql1) or die(mysql_error());
					while ($get1=mysql_fetch_assoc($res1))
						$delegateID=$delegateID.",".$get1["id"];
				}
				$delegateID=$delegateID.")";

				$flag=false;
				$sql2="SELECT id,speaker,`time`,`date`,delegation,content,header from speech";

				if ($headerID!="(0)")
				{
					if ($flag) $sql2=$sql2." AND ";
					else 
					{
						$sql2=$sql2." WHERE";
						$flag=true;
					}
					$sql2=$sql2." header in $headerID";
				}

				if ($delegateID!="(0)")
				{
					if ($flag) $sql2=$sql2." AND ";
					else 
					{
						$sql2=$sql2." WHERE";
						$flag=true;
					}
					$sql2=$sql2." speaker in $delegateID";
				}

				if ($delegationID!="(0)")
				{
					if ($flag) $sql2=$sql2." AND ";
					else 
					{
						$sql2=$sql2." WHERE";
						$flag=true;
					}
					$sql2=$sql2." delegation in $delegationID";
				}

				$keyword=protect($_GET["keyword"]);
				if (strlen($keyword)>0)
				{
					if ($flag) $sql2=$sql2." AND ";
					else 
					{
						$sql2=$sql2." WHERE";
						$flag=true;
					}	
					$sql2=$sql2." LOWER(content) like LOWER('%$keyword%') COLLATE utf8_bin";
				}

				$sql2=$sql2." ORDER BY date DESC, time DESC, id DESC";
				$res2=mysql_query($sql2) or die(mysql_error());
				//echo $sql2;
				$stt=0;
				while ($get2=mysql_fetch_assoc($res2))
				{
					$stt++;
					if ($stt<=100)
					{
						?>
						<tr>
							<td align='right'><?php echo $stt ?></td>
							<td><a href="speech.php?id=<?php echo $get2["id"]; ?>">Xem bài phát biểu</a></td>
							<td><?php printSession($get2["time"],$get2["date"],$get2["header"]); ?>							</td>
							<td><?php printLink("delegate",$get2["speaker"]); ?></td>
							<td><?php printLink("delegation",$get2["delegation"]); ?></td>
							<td><?php printTimeDate($get2["time"],$get2["date"]); ?></td>
						</tr>
						<?php
					}
				}

			?>
		</table>
		
		<?php
		echo "Tìm thấy $stt bài phát biểu.";
	}
	include("footer.php");
?>