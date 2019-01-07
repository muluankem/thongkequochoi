<?php
	include("function.php");
	include("header.php");
	connect();
?>
<title>Thống kê Quốc hội khóa XIV - Các lần biểu quyết</title>
<form action="vote.php" method="get">
Nội dung: <input type="text" name="name" value="<?php echo $_GET["name"]; ?>">
<input type="submit" name="ok" value="Tìm lần biểu quyết"><br>
</form>
<form action="vote.php" method="get" id="sort">
Sắp xếp các lần biểu quyết theo:<br>
<?php
	for ($i=1; $i<=4; $i++)
	{
		?>
		<select name="prio<?php echo $i; ?>">
			<option></option>
			<option value="yes" <?php if ($_GET["prio".$i]=="yes") echo "selected"; ?>>Số lượng phiếu thuận</option>
		<option value="no"  <?php if ($_GET["prio".$i]=="no") echo "selected"; ?>>Số lượng phiếu chống</option>
		<option value="white"  <?php if ($_GET["prio".$i]=="white") echo "selected"; ?>>Số lượng phiếu trắng</option>
		<option value="blank"  <?php if ($_GET["prio".$i]=="blank") echo "selected"; ?>>Số lượng đại biểu không biểu quyết</option>
		</select>
		<select  name="ord<?php echo $i; ?>">
			<option value="desc" <?php if ($_GET["ord".$i]=="desc") echo "selected"; ?>>Giảm dần</option>
			<option value="asc" <?php if ($_GET["ord".$i]=="asc") echo "selected"; ?>>Tăng dần</option>
		</select>
		<?php 
		if ($i!=4) echo "rồi đến<br>";
	}
	echo "<br>";
?>
<input type="submit" value="Sắp xếp" name="ok2">
</form>
<table>
	<colgroup>
       <col span="1" style="width: ;">
       <col span="1" style="width: ;">
       <col span="1" style="width: ;">
       <col span="1" style="width: ;">
       <col span="1" style="width: ;">
       <col span="1" style="width: ;">
       <col span="1" style="width: ;">
       <col span="1" style="width: 19%;">
       <col span="1" style="width: ;">
    </colgroup>
	<tr>
		<th></th>
		<th>Nội dung</th>
		<th>Thuận</th>
		<th>Chống</th>
		<th>Trắng</th>
		<th>Không bỏ phiếu</th>
		<th>Tổng</th>
		<th>Thời gian</th>
		<th></th>
	</tr>
	<?php
		if (strlen($_GET["name"])==0)
		{
			$prio1=protect($_GET["prio1"]);
			$prio2=protect($_GET["prio2"]);
			$prio3=protect($_GET["prio3"]);
			$prio4=protect($_GET["prio4"]);
			$ord1=protect($_GET["ord1"]);
			$ord2=protect($_GET["ord2"]);
			$ord3=protect($_GET["ord3"]);
			$ord4=protect($_GET["ord4"]);
			$sql1="SELECT * from vote order by ";
			if (strlen($_GET["prio1"])!=0)
				$sql1=$sql1."$prio1 $ord1, ";
			if (strlen($_GET["prio2"])!=0)
				$sql1=$sql1."$prio2 $ord2, ";
			if (strlen($_GET["prio3"])!=0)
				$sql1=$sql1."$prio3 $ord3, ";
			if (strlen($_GET["prio4"])!=0)
				$sql1=$sql1."$prio4 $ord4, ";
			$sql1=$sql1."`date` DESC, `time` DESC, id DESC";
			//echo $sql1;
			$res1=mysql_query($sql1) or die(mysql_error());
			$stt=0;
			while ($get1=mysql_fetch_assoc($res1))
			{
				$stt++;
				?>
				<tr>
					<td align="right"><?php echo $stt; ?></td>
					<td><?php echo $get1["name"]; ?></td>
					<td align="middle"><?php echo $get1["yes"]; ?></td>
					<td align="middle"><?php echo $get1["no"]; ?></td>
					<td align="middle"><?php echo $get1["white"]; ?></td>
					<td align="middle"><?php echo $get1["blank"]; ?></td>
					<td align="middle"><?php echo $get1["sum"]; ?></td>
					<td><?php printTimeDate($get1["time"],$get1["date"]); ?></td>
					<td><div class="fb-share-button" data-href="http://www.thongkequochoi.ga/votedetail.php?id=<?php echo $get1["id"]; ?>" data-layout="button_count"></div></td>
				</tr>
				<?php
			}
		}
		else
		{
			$name=protect($_GET["name"]);
			$sql1="SELECT * from vote WHERE LOWER(name) LIKE LOWER('%$name%') COLLATE utf8_bin order by `date` desc, `time` desc, id desc";
			$res1=mysql_query($sql1) or die(mysql_error());
			while ($get1=mysql_fetch_assoc($res1))
			{
				$stt++;
				?>
				<tr>
					<td align="right"><?php echo $stt; ?></td>
					<td><?php echo $get1["name"]; ?></td>
					<td align="middle"><?php echo $get1["yes"]; ?></td>
					<td align="middle"><?php echo $get1["no"]; ?></td>
					<td align="middle"><?php echo $get1["white"]; ?></td>
					<td align="middle"><?php echo $get1["blank"]; ?></td>
					<td align="middle"><?php echo $get1["sum"]; ?></td>
					<td><?php printTimeDate($get1["time"],$get1["date"]); ?></td>
					<td><div class="fb-share-button" data-href="http://www.thongkequochoi.ga/votedetail.php?id=<?php echo $get1["id"]; ?>" data-layout="button_count"></div></td>
				</tr>
				<?php
			}	
		}
	?>
</table>
<?php
	include("footer.php");
?>