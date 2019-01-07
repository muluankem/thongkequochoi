<?php
	include("header.php");
	include("function.php");
	connect();

	if (isset($_GET["id"]))
	{
		$id=protect($_GET["id"]);
		$sql="SELECT * from vote WHERE id=$id";
		$res=mysql_query($sql) or die(mysql_error());
		$get=mysql_fetch_assoc($res);
		?>
		<head>
			<title>Thống kê Quốc hội khóa XIV - Biểu quyết thông qua <?php echo $get["name"]; ?></title>
			<meta property="og:url"           content="http://www.thongkequochoi.ga/votedetail.php?id=<?php echo $get["id"]; ?>" />
			<meta property="og:type"          content="website" />
  			<meta property="og:title"         content="Thống kê Quốc hội khóa XIV - Biểu quyết thông qua <?php echo $get["name"]; ?>">
  			<meta property="og:description"   content="Vào <?php printTimeDate($get["time"],$get["date"]); ?>, Quốc hội đã biểu quyết thông qua <?php echo $get["name"]; ?> với <?php echo $get["yes"]; ?> phiếu thuận, <?php echo $get["no"]; ?> phiếu chống, <?php echo $get["white"]; ?> phiếu trắng. Có <?php echo $get["blank"]; ?> đại biểu không tham gia biểu quyết." />
  		</head>
		<h3>Biểu quyết thông qua <?php echo $get["name"]; ?> </h3>
		<p>Vào <?php printTimeDate($get["time"],$get["date"]); ?>, Quốc hội đã biểu quyết thông qua <?php echo $get["name"]; ?> với <?php echo $get["yes"]; ?> phiếu thuận, <?php echo $get["no"]; ?> phiếu chống, <?php echo $get["white"]; ?> phiếu trắng. Có <?php echo $get["blank"]; ?> đại biểu không tham gia biểu quyết.</p>
		<?php
	}
?>