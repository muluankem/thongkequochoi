<?php
	include("function.php");
	include("header.php");
	connect();

	if (isset($_GET["id"]))
	{
		$idSpeech=protect($_GET["id"]);
		$sql="SELECT * from speech WHERE id=$idSpeech";
		$res=mysql_query($sql) or die(mysql_error());
		$get=mysql_fetch_assoc($res);
		?>
		<title>Thống kê Quốc hội khóa XIV - Đại biểu <?php echo getName("delegate",$get["speaker"]); ?> - <?php echo getName("header",$get["header"]) ?></title>
		<meta property="og:url"           content="http://www.thongkequochoi.ga/speech.php?id=<?php echo $get["id"]; ?>" />
		<meta property="og:type"          content="website" />
  		<meta property="og:title"         content="Thống kê Quốc hội khóa XIV - Đại biểu <?php echo getName("delegate",$get["speaker"]); ?> - <?php echo getName("header",$get["header"]) ?>" />
		<?php
		echo "<h3>";
		printSession($get["time"],$get["date"],$get["header"]);
		echo "</h3>";
		echo getName("time",$get["time"])." "." ngày ".date("d",strtotime($get["date"]))." tháng ".date("m",strtotime($get["date"]))." năm ".date("Y",strtotime($get["date"]))."<br>";
		echo "<h4>";
		printLink("delegate",$get["speaker"]);
		echo " - ";
		printLink("delegation",$get["delegation"]);
		echo "</h4>";
		echo $get["content"];
		?>
		<div class="fb-like" data-href="http://www.thongkequochoi.ga/speech.php?id=<?php echo $get["id"]; ?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
		</div>
  		<?php
	}
	include("footer.php");
?>