<title>Thống kê Quốc hội khóa XIV - Các đoàn đại biểu</title>
<?php
	include("function.php");
	include("header.php");
	connect();
?>
<form action="delegationrank.php" metdod="get">
Đoàn đại biểu: <input type="text" name="delegation">
<input type="submit" name="submit" value="Tìm đoàn đại biểu">
</form>
<?php
	if (isset($_GET["page"])) $page=protect($_GET["page"]);
		else $page=1;
	if (strlen($_GET["delegation"])==0)
	{
		printPage("SELECT id from delegation",$page,"delegationrank");
	}
?>
<table>
	<tr>
		<th></th>
		<th>Đoàn đại biểu</th>
		<th>Số Đại biểu</th>
		<th>Số lần phát biểu</th>
	</tr>
<?php
	if (strlen($_GET["delegation"])==0)
	{
		if (isset($_GET["page"])) $page=protect($_GET["page"]);
		else $page=1;
		$lastpage=false;
		for ($stt=$page*100-99; $stt<=$page*100; $stt++)
		{
			$sql1="SELECT id,num,sum from delegation WHERE rank=$stt";
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
			<td><?php printLink("delegation",$get1["id"]); ?></td>
			<td align='center'><?php echo $get1["num"]; ?></td>
			<td align='center'><?php echo $get1["sum"]; ?></td>
			<?php
			echo "</tr>";
		}
	}
	else
	{
		$delegationName=protect($_GET["delegation"]);
		$sql1="SELECT id,num,sum,rank from delegation WHERE LOWER(name) LIKE LOWER('%$delegationName%') COLLATE utf8_bin";
		$res1=mysql_query($sql1) or die(mysql_error());
		while ($get1=mysql_fetch_assoc($res1))
		{
			echo "<tr>";
			echo "<td align='right'>".$get1["rank"]."</td>";
			?>
			<td><?php printLink("delegation",$get1["id"]); ?></td>
			<td align='center'><?php echo $get1["num"]; ?></td>
			<td align='center'><?php echo $get1["sum"]; ?></td>
			<?php
			echo "</tr>";
		}
	}
?>
</table>
<?php
if (strlen($_GET["delegation"])==0)
{
	if (strlen($_GET["delegation"])==0)
		printPage("SELECT id from delegation",$page,"delegationrank");
}
else
{
	echo "Tìm thấy ".mysql_num_rows($res1)." đoàn đại biểu.";
}
	include("footer.php");
?>
