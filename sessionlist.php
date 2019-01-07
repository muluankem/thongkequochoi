<title>Thống kê Quốc hội khóa XIV - Các phiên làm việc</title>
<?php
	include("function.php");
	include("header.php");
	connect();	
?>
<form action="sessionlist.php" metdod="get" name="search">
Nội dung: <input type="text" name="header" value="<?php echo $_GET["header"]; ?>">
Thời gian:
<select name="time">
	<option value=0></option>
	<option value=1 <?php if ($_GET["time"]==1) echo "selected"; ?> >Sáng</option>
	<option value=2 <?php if ($_GET["time"]==2) echo "selected"; ?> >Chiều</option>
</select>
Ngày <input type="text" name="day" size=1 value="<?php echo $_GET["day"]; ?>">
tháng <input type="text" name="month" size=1 value="<?php echo $_GET["month"]; ?>">
năm <input type="text" name="year" size=1 value="<?php echo $_GET["year"]; ?>">
<input type="submit" value="Tìm phiên làm việc" name="submit">
</form>
<?php
	if (isset($_GET["page"])) $page=protect($_GET["page"]);
		else $page=1;
	if (strlen($_GET["header"])==0 and strlen($_GET["day"])==0 and strlen($_GET["month"])==0 and strlen($_GET["year"])==0 and $_GET["time"]==0)
			printPage("SELECT id from session",$page,"sessionlist");
?>
<table>
	<colgroup>
		<col span="1" style="width: ;">
        <col span="1" style="width: ;">
        <col span="1" style="width: 19%;">
    </colgroup>
	<tr>
		<th></th>
		<th>Nội dung</th>
		<th>Thời gian</th>
	</tr>
	<?php
		if (isset($_GET["page"])) $page=protect($_GET["page"]);
		else $page=1;
		$lastpage=false;
		if (strlen($_GET["header"])==0 and strlen($_GET["day"])==0 and strlen($_GET["month"])==0 and strlen($_GET["year"])==0 and $_GET["time"]==0)
		{
			for ($stt=$page*100-99; $stt<=$page*100; $stt++)
			{
				$sql1="SELECT header,`time`,`date` from session WHERE rank=$stt";
				$res1=mysql_query($sql1) or die(mysql_error());
				if (mysql_num_rows($res1)==0)
				{
					$lastpage=true;
					break;
				}
				$get1=mysql_fetch_assoc($res1);
				echo "<tr>";
				echo "<td align='right'>$stt</td>";
				?>
				<td>
					<?php printSession($get1["time"],$get1["date"],$get1["header"]); ?>
				</td>
				<td><?php echo getName("time",$get1["time"])." ngày ".date("d",strtotime($get1["date"]))." tháng ".date("m",strtotime($get1["date"]))." năm ".date("Y",strtotime($get1["date"])); ?></td>
				<?php
				echo "</tr>";
			}
		}
		else
		{
			if (strlen($_GET["header"])!=0)
			{
				$headerName=protect($_GET["header"]);
				$sql1="SELECT id from header WHERE LOWER(name) LIKE LOWER('%$headerName%') COLLATE utf8_bin";
				$res1=mysql_query($sql1) or die(mysql_error());
				$headerID="(0";
				$flag=true;
				while ($get1=mysql_fetch_assoc($res1))
				{
					if ($flag) $headerID=$headerID.",";
					else $flag=true;
					$headerID=$headerID.$get1["id"];
				}
				$headerID=$headerID.")";
			}
			$sql2="SELECT header,`time`,`date` from session";
			$flag=true;
			if (isset($headerID) and $headerID!="()") 
			{
				if ($flag) 
				{
					$sql2=$sql2." WHERE ";
					$flag=false;
				}
				else
					$sql2=$sql2." AND ";
				$sql2=$sql2."header in $headerID";
			}
			if ($_GET["time"]!=0) 
			{
				$getTime=protect($_GET["time"]);
				if ($flag) 
				{
					$sql2=$sql2." WHERE ";
					$flag=false;
				}
				else
					$sql2=$sql2." AND ";
				$sql2=$sql2."`time`=$getTime";
			}
			$date="";
			if (strlen($_GET["year"])!=0)
				$date=$date."%".protect($_GET["year"])."%";
			else
				$date=$date."%";
			$date=$date."-";
			if (strlen($_GET["month"])!=0)
				$date=$date."%".protect($_GET["month"])."%";
			else
				$date=$date."%";
			$date=$date."-";
			if (strlen($_GET["day"])!=0)
				$date=$date."%".protect($_GET["day"])."%";
			else
				$date=$date."%";

			if ($flag) 
			{
				$sql2=$sql2." WHERE ";
				$flag=false;
			}
			else
				$sql2=$sql2." AND ";
			
			$sql2=$sql2."`date` LIKE '$date' ORDER BY date DESC, time DESC";
			//echo $sql2;
			$res2=mysql_query($sql2) or die(mysql_error());
			$stt=0;
			while ($get1=mysql_fetch_assoc($res2))
			{
				$stt++;
				echo "<tr>";
				echo "<td align='right'>$stt</td>";
				?>
				<td>
					<a href="session.php?time=<?php echo $get1["time"]; ?>&date=<?php echo $get1["date"]; ?>&id=<?php echo $get1["header"]; ?>">
					<?php  
							echo getName("header",$get1["header"]);
					?>
					</a>
				</td>
				<td><?php echo getName("time",$get1["time"])." ngày ".date("d",strtotime($get1["date"]))." tháng ".date("m",strtotime($get1["date"]))." năm ".date("Y",strtotime($get1["date"])); ?></td>
				<?php
				echo "</tr>";
			}
		}

	?>
</table>
<?php
if (strlen($_GET["header"])==0 and strlen($_GET["day"])==0 and strlen($_GET["month"])==0 and strlen($_GET["year"])==0 and $_GET["time"]==0)
{
	printPage("SELECT id from session",$page,"sessionlist");
}
else
{
	echo "Tìm thấy $stt phiên làm việc";
}
	include("footer.php");
?>
