<?php
	include("function.php");
	include("header.php");
	connect();
	if (isset($_GET["id"]))
	{
		$idDelegate=protect($_GET["id"]);
		?>
		<title>Thống kê Quốc hội khóa XIV - Đại biểu <?php echo getName("delegate",$idDelegate); ?></title>
		<h3><?php echo "Đại biểu ".getName("delegate",$idDelegate); ?></h3>
		<table>
		<colgroup>
			<col span="1" style="width: ;">
       		<col span="1" style="width: ;">
       		<col span="1" style="width: 15%;">
       		<col span="1" style="width: 19%;">
  		</colgroup>
		<tr>
			<th></th>
			<th>Nội dung</th>
			<th>Đoàn</th>
			<th>Thời gian</th>
		</tr>
		<?php
		$sql1="SELECT id,header,`time`,`date`,delegation from speech WHERE speaker=$idDelegate ORDER BY `date` DESC, `time` DESC, id DESC";
		$res1=mysql_query($sql1) or die(mysql_error());
		$stt=0;
		while ($get1=mysql_fetch_assoc($res1))
		{
			$stt++;
			?>
			<tr>
				<td align='right'><?php echo $stt; ?></td>
				<td>
					<a href="speech.php?id=<?php echo $get1["id"]; ?>">
					<?php
							echo getName("header",$get1["header"]);
					?>
					</a>
				</td>
				<td><?php echo printLink("delegation",$get1["delegation"]); ?></td>
				<td><?php echo getName("time",$get1["time"])." ngày ".date("d",strtotime($get1["date"]))." tháng ".date("m",strtotime($get1["date"]))." năm ".date("Y",strtotime($get1["date"])); ?></td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}
	include("footer.php");
?>