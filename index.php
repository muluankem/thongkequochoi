<title>Thống kê Quốc hội khóa XIV - Các đại biểu</title>
<?php
	include("function.php");
	include("header.php");
	connect();
?>
<form method="get" action="index.php">
Đại biểu: <input type="text" name="delegate" value="<?php if (isset($_GET["delegate"])) echo $_GET["delegate"]; ?>" >
Đoàn: <input type="text" name="delegation" value="<?php if (isset($_GET["delegation"])) echo $_GET["delegation"]; ?>">
<input value="Tìm đại biểu" name="find" type="submit">
</form>
<?php
if (strlen($_GET["delegate"])==0 and strlen($_GET["delegation"])==0)
{
	if (isset($_GET["page"])) 
	{
		$page=protect($_GET["page"]);
		if ($page==0) $page=1;
	}
	else $page=1;
	printPage("SELECT id from delegate",$page,"index");
}
?>
<table>
	<tr>
		<th></th>
		<th>Đại biểu</th>
		<th>Đoàn</th>
		<th>Số lần phát biểu</th>
	</tr>
	<?php
		if (isset($_GET["page"])) 
		{
			$page=protect($_GET["page"]);
			if ($page==0) $page=1;
		}
		else $page=1;
		if (strlen($_GET["delegate"])==0 and strlen($_GET["delegation"])==0)
		{
			$lastpage=false;
			for ($stt=$page*100-99; $stt<=$page*100; $stt++)
			{
				$sql1="SELECT id,score,delegation from delegate WHERE rank=$stt";
				$res1=mysql_query($sql1) or die(mysql_error());
				if (mysql_num_rows($res1)==0)
				{
					$lastpage=true;
					break;
				}
				$get1=mysql_fetch_assoc($res1);
				?>
				<tr <?php if ($get1["score"]==0) echo "style=\"display:none;\""; ?> >
				<?php
				echo "<td align='right'>$stt</td>";
				?>
				<td><?php printLink("delegate",$get1["id"]); ?></td>
				<td><?php printLink("delegation",$get1["delegation"]);?></td>
				<?php
				echo "<td align='center'>".$get1["score"]."</td>";
				echo "</tr>";
			}
		}
		else
		{
			$delegateName=protect($_GET["delegate"]);
			$delegationName=protect($_GET["delegation"]);
			
			if (strlen($delegationName)>0)
			{
				$sql2="SELECT id from delegation WHERE LOWER(name) LIKE LOWER('%$delegationName%') COLLATE utf8_bin";
				$res2=mysql_query($sql2) or die(mysql_error());
				$delegationID="(0";
				$flag=true;
				while ($get2=mysql_fetch_assoc($res2))
				{
					if ($flag) $delegationID=$delegationID.",";
					else $flag=true;
					$delegationID=$delegationID.$get2["id"];
				}
				$delegationID=$delegationID.")";
			}

			if (isset($delegationID)) $sql1="SELECT id,score,delegation,rank from delegate WHERE LOWER(name) LIKE LOWER('%$delegateName%') COLLATE utf8_bin and delegation in $delegationID ORDER BY score DESC";
			else
			$sql1="SELECT id,score,delegation,rank from delegate WHERE LOWER(name) LIKE LOWER('%$delegateName%') COLLATE utf8_bin ORDER BY score DESC";
			$res1=mysql_query($sql1) or die(mysql_error());
			$total=mysql_num_rows($res1);
			while ($get1=mysql_fetch_assoc($res1))
			{
				?>
				<tr <?php if ($get1["score"]==0) { echo "style=\"display:none;\""; $total--; } ?> >
					<td align='left'><?php echo $get1["rank"]; ?></td>
					<td><?php printLink("delegate",$get1["id"]); ?></td>
					<td><?php printLink("delegation",$get1["delegation"]); ?></td>
					<td align='center'><?php echo $get1["score"] ?></td>
				</tr>
				<?php
			}
		}
	?>
</table>
<?php

if (strlen($_GET["delegate"])==0 and strlen($_GET["delegation"])==0)
{
	printPage("SELECT id from delegate",$page,"index");
}
else
{
	echo "Tìm thấy $total đại biểu.";
}
	include("footer.php");
?>
