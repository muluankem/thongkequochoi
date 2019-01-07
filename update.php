<?php
	include("function.php");
	ini_set('max_execution_time', 3600);
	for ($i=1; $i<=4; $i++)
	{
		include("updaterank.php");
		include("updatedelegation.php");
		include("updatesession.php");
		include("updatedelegationscore.php");
	}
?>