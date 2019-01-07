<?php
	include("function.php");
	include("header.php");
	connect();
	if (isset($_GET["id"]))
	{
		$idDelegation=protect($_GET["id"]);
		?>
			<title>Thống kê Quốc hội khóa XIV - Đoàn <?php echo getName("delegation",$idDelegation) ?></title>
			<h3>Đoàn <?php echo getName("delegation",$idDelegation) ?></h3>
		<?php
	}
?>
<table>
	<tr>
		<th></th>
		<th>Đại biểu</th>
		<th>Số lần phát biểu</th>
	</tr>
<?php

	if (isset($_GET["id"]))
	{
		$idDelegation=protect($_GET["id"]);
		$sql="SELECT id,score from delegate where delegation=$idDelegation ORDER BY score DESC";
		$res=mysql_query($sql) or die(mysql_error());
		$stt=0;
		while ($get=mysql_fetch_assoc($res))
		{
			$stt++;
			?>
			<tr <?php if ($get["score"]==0) echo "style=\"display:none;\""; ?> >
				<td align='right'> <?php echo $stt; ?></td>
				<td> <?php printlink("delegate",$get["id"]); ?> </td>
				<td align='center'> <?php echo $get["score"]; ?></td>
			</tr>
			<?php
		}

	}
?>

</table>
<?php
	include("footer.php");
?>